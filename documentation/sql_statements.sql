--Users
create user guest@localhost identified by "guest";
create user moderator@localhost identified by "moderator";

--Roles
--Guest
grant select on event_calendar.* to guest@localhost;

--Moderator
grant select on event_calendar.* to moderator@localhost;
--(no tbl_user)
grant insert, update, delete on event_calendar.tbl_price_bracket to moderator@localhost;
grant insert, update, delete on event_calendar.tbl_event to moderator@localhost;
grant insert, update, delete on event_calendar.tbl_event_price to moderator@localhost;
grant insert, update, delete on event_calendar.tbl_link to moderator@localhost;
grant insert, update, delete on event_calendar.tbl_performance to moderator@localhost;
grant insert, update, delete on event_calendar.tbl_genre to moderator@localhost;

--Data
--In tbl_user
insert into tbl_user (username, password) values ("Moderator", MD5("1234"));
