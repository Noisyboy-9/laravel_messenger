# --------------------------------------users-----------------------------------
create table users
(
    id           int primary key auto_increment,
    username     varchar(200) unique,
    email        varchar(320) unique,
    first_name   varchar(200),
    last_name    varchar(200),
    phone_number char(11),
    password     varchar(200),
    token        char(200),
    deleted_at   timestamp default null,
    created_at   timestamp default current_timestamp
);

create index username_idx on users (username);
create index email_idx on users (email);
create index deleted_at_idx on users (deleted_at);
create index token_idx on users (token);
# -- on user creation create:
# a row in failed_login_attempt table with attempt_count = 0
# a row in failed_password_resets_table with attempt_count = 0
create trigger on_user_creation_add_failed_attempt_empty_rows after insert on users
    for each row
    begin
       insert into failed_login_attempts(user_id, failed_attempts_count) values (NEW.id, 0);
       insert into failed_password_recover_attempts (user_id, failed_attempts_count) values (NEW.id, 0);
    end;

# --------------------------------------security_question-----------------------------------
create table security_questions
(
    id    int primary key auto_increment,
    title varchar(300)
);

create table security_questions_answers
(
    answerer_id int,
    question_id int,
    answer      longtext,
    answered_at timestamp default current_timestamp,
    primary key (answerer_id, question_id),
    foreign key (answerer_id) references users (id) on delete cascade,
    foreign key (question_id) references security_questions (id) on delete cascade
);

# --------------------------------------messages-----------------------------------
create table messages
(
    id          int primary key auto_increment,
    body        longtext,
    sender_id   int,
    receiver_id int,
    seen        bool      default false,
    sent_at     timestamp default current_timestamp,
    deleted_at  timestamp default current_timestamp,
    foreign key (sender_id) references users (id) on delete cascade,
    foreign key (receiver_id) references users (id) on delete cascade
);
create index msg_sender_id_idx on messages (sender_id);
create index msg_receiver_id_idx on messages (sender_id);
create index msg_deleted_at_idx on messages (sender_id);


create table likes
(
    message_id int,
    liker_id   int,
    liked_at   timestamp default current_timestamp,
    deleted_at timestamp default null,
    primary key (message_id, liker_id),
    foreign key (message_id) references messages (id) on delete cascade,
    foreign key (liker_id) references users (id) on delete cascade
);
create index likes_deleted_at_idx on likes (deleted_at);

# --------------------------------------blocks-----------------------------------
create table blocks
(
    blocker_id int,
    blocked_id int,
    blocked_at timestamp default current_timestamp,
    deleted_at timestamp default null,
    primary key (blocker_id, blocked_id),
    foreign key (blocked_id) references users (id) on delete cascade,
    foreign key (blocker_id) references users (id) on delete cascade
);
create index blocks_deleted_at_idx on blocks (deleted_at);

create trigger on_user_block_remove_connections
    after delete
    on blocks
    for each row
begin
    delete from connections where connector_id = OLD.blocker_id;
    delete from connections where connector_id = OLD.blocked_id;
end;
# --------------------------------------active sessions-----------------------------------
create table active_sessions
(
    user_id    int,
    ip_address char(12),
    started_at timestamp default current_timestamp,
    ended_at   timestamp default null,
    deleted_at timestamp default null,
    primary key (user_id, ip_address),
    foreign key (user_id) references users (id) on delete cascade
);
create index active_sessions_deleted_at_idx on active_sessions (deleted_at);
# --------------------------------------invitations-----------------------------------
create table invitations
(
    inviter_id  int,
    invited_id  int,
    accepted_at timestamp default current_timestamp,
    deleted_at  timestamp default null,
    primary key (inviter_id, invited_id),
    foreign key (inviter_id) references users (id) on delete cascade,
    foreign key (invited_id) references users (id) on delete cascade
);

create index invitations_deleted_at_idx on invitations (deleted_at);

# --------------------------------------connections-----------------------------------
create table connections
(
    connector_id int,
    connected_id int,
    deleted_at   timestamp default null,
    primary key (connector_id, connected_id),
    foreign key (connected_id) references users (id) on delete cascade,
    foreign key (connector_id) references users (id) on delete cascade
);

create index connections_deleted_at_idx on connections (deleted_at);

create trigger two_way_connections
    after insert
    on connections
    for each row
begin
    insert connections(connector_id, connected_id) value (NEW.connected_id, NEW.connector_id);
end;
# --------------------------------------failed attempts-----------------------------------
create table failed_login_attempts
(
    id                    int primary key auto_increment,
    user_id               int,
    failed_attempts_count smallint,
    penalty_start         timestamp default null,
    penalty_end           timestamp default null,

    foreign key (user_id) references users (id) on delete cascade on update cascade
);

create table failed_password_recover_attempts
(
    id                    int primary key auto_increment,
    user_id               int,
    failed_attempts_count smallint,
    penalty_start         timestamp default null,
    penalty_end           timestamp default null,

    foreign key (user_id) references users (id) on delete cascade on update cascade
);

# add penalty_start and penalty_end
drop trigger failed_login_attempts_penalty_start;

create trigger failed_login_attempts_penalty_start
    before update on failed_login_attempts
    for each row
    begin
        IF(NEW.failed_attempts_count = 3) then
           set NEW.penalty_start = current_timestamp,
               NEW.penalty_end = DATE_ADD(NOW(), INTERVAL 3 DAY);
        end if;
    end;

create trigger failed_password_recover_attempts_penalty_start
    after update on failed_password_recover_attempts
    for each row
    begin
        IF(NEW.failed_attempts_count = 5) then
            update failed_password_recover_attempts
            set penalty_start = current_timestamp,
                penalty_end = DATE_ADD(NOW(), INTERVAL 5 DAY)
            WHERE id = NEW.id;
        end if;
    end;
# --------------------------------------logs-----------------------------------
create table logs
(
    id            int primary key auto_increment,
    priority      enum ('warning', 'error', 'info'),
    trigger_table varchar(300),
    body          mediumtext,
    created_at timestamp default current_timestamp
);

# triggers for creating logs
# users logging
create trigger users_creation_logger
    after insert
    on users
    for each row
begin
    insert into logs(priority, trigger_table, body)
        value ('info', 'users', concat('A user has been created with username: ', NEW.username));
end;

create trigger users_delete_logger
    after delete
    on users
    for each row
begin
    insert into logs(priority, trigger_table, body)
        value ('info', 'users', concat('A user has been soft_deleted with username: ', OLD.username));
end;


create trigger users_update_logger
    after update
    on users
    for each row
begin
    insert into logs(priority, trigger_table, body) value ('info', 'users',
                                                           concat('A user has updated its credentials', NEW.username));
end;

# security questions logger
create trigger security_questions_answer_creation_logger
    after insert
    on security_questions_answers
    for each row
begin
    insert into logs(priority, trigger_table, body) value ('info', 'security_questions_answers',
                                                           concat('a user with id: ', @answerer_id,
                                                                  ' has answered a security question with id:  ',
                                                                  @question_id));
end;

# messages logger
create trigger messages_creation_logger
    after insert
    on messages
    for each row
begin
    insert into logs(priority, trigger_table, body) value ('info', 'messages',
                                                           concat('a message been sent by: ', NEW.sender_id,
                                                                  'to receiver: ', NEW.receiver_id));
end;


create trigger messages_delete_logger
    after delete
    on messages
    for each row
begin
    insert into logs(priority, trigger_table, body) value ('info', 'messages',
                                                           concat('a message with id: ', OLD.id, 'has been deleted'));
end;


create trigger message_update_logger
    after delete
    on messages
    for each row
begin
    insert into logs(priority, trigger_table, body) value ('info', 'messages',
                                                           concat('a message with id: ', OLD.id, 'has been updated'));
end;


create trigger message_like_create_logger
    after insert
    on likes
    for each row
begin
    insert into logs(priority, trigger_table, body) value ('info', 'like',
                                                           concat('a message with id: ', NEW.message_id,
                                                                  ' has been liked by: ', NEW.liker_id));
end;

create trigger message_like_delete_logger
    after delete
    on likes
    for each row
begin
    insert into logs(priority, trigger_table, body)
        value ('info', 'like', concat('a like with id on message with id: ', OLD.message_id, ' has been removed'));
end;

# blocks logger
create trigger blocks_creation_logger
    after insert
    on blocks
    for each row
begin
    insert into logs(priority, trigger_table, body) value ('info', 'blocks', concat('a user with id: ', NEW.blocker_id,
                                                                                    ' has blocked user with id: ',
                                                                                    NEW.blocked_id));
end;

create trigger blocks_delete_logger
    after delete
    on blocks
    for each row
begin
    insert into logs(priority, trigger_table, body) value ('info', 'blocks', concat('a user with id: ', OLD.blocker_id,
                                                                                    ' has unblocked user with id: ',
                                                                                    OLD.blocked_id));
end;


# active session logger
create trigger active_sessions_create_logger
    after insert
    on active_sessions
    for each row
begin
    insert into logs(priority, trigger_table, body) value ('info', 'active_sessions',
                                                           concat('a new session for user with id: ', NEW.user_id,
                                                                  ' and ip address: ', NEW.ip_address));
end;

create trigger active_sessions_delete_table
    after delete
    on active_sessions
    for each row
begin
    insert into logs(priority, trigger_table, body)
        VALUE ('info', 'active_sessions',
               concat('a user with id: ', OLD.user_id, ' has logged out of its session with ip address: ',
                      OLD.ip_address));
end;


# invitation logger
create trigger invitation_creation_logger
    after insert
    on invitations
    for each row
begin
    insert into logs(priority, trigger_table, body) value ('info', 'invitations',
                                                           concat('a user with id: ', NEW.inviter_id, ' has invited: ',
                                                                  NEW.invited_id));
end;

create trigger invitation_deletion_trigger
    after delete
    on invitations
    for each row
begin
    insert into logs(priority, trigger_table, body) value ('info', 'invitations',
                                                           concat('a user with id: ', OLD.inviter_id,
                                                                  ' has remove its invitation for user with id: ',
                                                                  OLD.invited_id));
end;
# connections logger
create trigger connection_creation_logger
    after insert
    on connections
    for each row
begin
    insert into logs(priority, trigger_table, body) value ('info', 'invitations',
                                                           concat('a user with id: ', NEW.connector_id,
                                                                  ' has connected with: ', NEW.connector_id));
end;

create trigger connection_deletion_logger
    after delete
    on connections
    for each row
begin
    insert into logs(priority, trigger_table, body) value ('info', 'invitations',
                                                           concat('a user with id: ', OLD.connector_id,
                                                                  ' has removed connection with: ', OLD.connected_id));
end;
