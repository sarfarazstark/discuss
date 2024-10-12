create database discuss
    with owner postgres;

create table public.users
(
    id         serial
        primary key,
    username   varchar(50)  not null,
    email      varchar(100) not null,
    password   varchar(255) not null,
    created_at timestamp default CURRENT_TIMESTAMP
);

alter table public.users
    owner to postgres;

create table public.category
(
    id            serial
        primary key,
    category_name varchar(255) not null
);

alter table public.category
    owner to postgres;

create table public.questions
(
    id          serial
        primary key,
    title       varchar(50),
    description text,
    category_id integer
        constraint fk_qs_ctgry
            references public.category
            on delete cascade,
    user_id     integer
        constraint fk_user_qs
            references public.users
            on delete cascade,
    created_at  timestamp
);

alter table public.questions
    owner to postgres;

create table public.responses
(
    id          serial
        primary key,
    response    text not null,
    question_id integer
        references public.questions,
    user_id     integer
        references public.users,
    created_at  timestamp
);

alter table public.responses
    owner to postgres;
