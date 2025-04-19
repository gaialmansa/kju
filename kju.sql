--
-- PostgreSQL database dump
--

-- Dumped from database version 16.8 (Ubuntu 16.8-0ubuntu0.24.04.1)
-- Dumped by pg_dump version 16.8 (Ubuntu 16.8-0ubuntu0.24.04.1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: upsert_zfx_userattribute(integer, text, text); Type: FUNCTION; Schema: public; Owner: pofenas
--

CREATE FUNCTION public.upsert_zfx_userattribute(iduser integer, attcode text, attvalue text) RETURNS void
    LANGUAGE plpgsql
    AS $$
    BEGIN
        LOOP
            UPDATE zfx_userattribute
            SET value = attvalue
            WHERE code = attcode
              AND id_user = iduser;
            IF found THEN
                RETURN;
            END IF;
            BEGIN
                INSERT INTO zfx_userattribute(id_user, code, value)
                VALUES (iduser, attcode, attvalue);
                RETURN;
            EXCEPTION
                WHEN unique_violation THEN
            END;
        END LOOP;
    END;
    $$;


ALTER FUNCTION public.upsert_zfx_userattribute(iduser integer, attcode text, attvalue text) OWNER TO pofenas;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: opciones; Type: TABLE; Schema: public; Owner: pofenas
--

CREATE TABLE public.opciones (
    id_opcion integer NOT NULL,
    id_pregunta integer NOT NULL,
    "opTexto" character varying(256) NOT NULL,
    correcta boolean DEFAULT false NOT NULL
);


ALTER TABLE public.opciones OWNER TO pofenas;

--
-- Name: opciones_id_opcion_seq; Type: SEQUENCE; Schema: public; Owner: pofenas
--

CREATE SEQUENCE public.opciones_id_opcion_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.opciones_id_opcion_seq OWNER TO pofenas;

--
-- Name: opciones_id_opcion_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: pofenas
--

ALTER SEQUENCE public.opciones_id_opcion_seq OWNED BY public.opciones.id_opcion;


--
-- Name: ponencias; Type: TABLE; Schema: public; Owner: pofenas
--

CREATE TABLE public.ponencias (
    id_ponencia integer NOT NULL,
    "Nombre" character varying(256) NOT NULL,
    id_user integer NOT NULL,
    terminada boolean DEFAULT false NOT NULL
);


ALTER TABLE public.ponencias OWNER TO pofenas;

--
-- Name: ponencias_id_seq; Type: SEQUENCE; Schema: public; Owner: pofenas
--

CREATE SEQUENCE public.ponencias_id_seq
    AS smallint
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.ponencias_id_seq OWNER TO pofenas;

--
-- Name: ponencias_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: pofenas
--

ALTER SEQUENCE public.ponencias_id_seq OWNED BY public.ponencias.id_ponencia;


--
-- Name: preguntas; Type: TABLE; Schema: public; Owner: pofenas
--

CREATE TABLE public.preguntas (
    id_pregunta integer NOT NULL,
    id_ponencia integer NOT NULL,
    texto character varying(256) NOT NULL,
    abierto boolean DEFAULT false NOT NULL,
    orden smallint NOT NULL
);


ALTER TABLE public.preguntas OWNER TO pofenas;

--
-- Name: preguntas_id_pregunta_seq; Type: SEQUENCE; Schema: public; Owner: pofenas
--

CREATE SEQUENCE public.preguntas_id_pregunta_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.preguntas_id_pregunta_seq OWNER TO pofenas;

--
-- Name: preguntas_id_pregunta_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: pofenas
--

ALTER SEQUENCE public.preguntas_id_pregunta_seq OWNED BY public.preguntas.id_pregunta;


--
-- Name: respuestas; Type: TABLE; Schema: public; Owner: pofenas
--

CREATE TABLE public.respuestas (
    id_respuesta integer NOT NULL,
    id_pregunta integer NOT NULL,
    id_opcion integer NOT NULL,
    ip character varying(16) NOT NULL
);


ALTER TABLE public.respuestas OWNER TO pofenas;

--
-- Name: respuestas_id_respuesta_seq; Type: SEQUENCE; Schema: public; Owner: pofenas
--

CREATE SEQUENCE public.respuestas_id_respuesta_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.respuestas_id_respuesta_seq OWNER TO pofenas;

--
-- Name: respuestas_id_respuesta_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: pofenas
--

ALTER SEQUENCE public.respuestas_id_respuesta_seq OWNED BY public.respuestas.id_respuesta;


--
-- Name: zfx_group; Type: TABLE; Schema: public; Owner: pofenas
--

CREATE TABLE public.zfx_group (
    id integer NOT NULL,
    name character varying(64) NOT NULL,
    description character varying(1024) NOT NULL,
    ref1 integer,
    ref2 integer
);


ALTER TABLE public.zfx_group OWNER TO pofenas;

--
-- Name: zfx_group_id_seq; Type: SEQUENCE; Schema: public; Owner: pofenas
--

CREATE SEQUENCE public.zfx_group_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.zfx_group_id_seq OWNER TO pofenas;

--
-- Name: zfx_group_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: pofenas
--

ALTER SEQUENCE public.zfx_group_id_seq OWNED BY public.zfx_group.id;


--
-- Name: zfx_group_permission; Type: TABLE; Schema: public; Owner: pofenas
--

CREATE TABLE public.zfx_group_permission (
    id_group integer NOT NULL,
    id_permission integer NOT NULL
);


ALTER TABLE public.zfx_group_permission OWNER TO pofenas;

--
-- Name: zfx_permission; Type: TABLE; Schema: public; Owner: pofenas
--

CREATE TABLE public.zfx_permission (
    id integer NOT NULL,
    code character varying(128) NOT NULL,
    description character varying(1024) NOT NULL
);


ALTER TABLE public.zfx_permission OWNER TO pofenas;

--
-- Name: zfx_permission_id_seq; Type: SEQUENCE; Schema: public; Owner: pofenas
--

CREATE SEQUENCE public.zfx_permission_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.zfx_permission_id_seq OWNER TO pofenas;

--
-- Name: zfx_permission_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: pofenas
--

ALTER SEQUENCE public.zfx_permission_id_seq OWNED BY public.zfx_permission.id;


--
-- Name: zfx_user; Type: TABLE; Schema: public; Owner: pofenas
--

CREATE TABLE public.zfx_user (
    id integer NOT NULL,
    login character varying(64) NOT NULL,
    password_hash character(32) NOT NULL,
    language character(2) NOT NULL,
    ref1 integer,
    ref2 integer
);


ALTER TABLE public.zfx_user OWNER TO pofenas;

--
-- Name: zfx_user_group; Type: TABLE; Schema: public; Owner: pofenas
--

CREATE TABLE public.zfx_user_group (
    id_user integer NOT NULL,
    id_group integer NOT NULL
);


ALTER TABLE public.zfx_user_group OWNER TO pofenas;

--
-- Name: zfx_user_id_seq; Type: SEQUENCE; Schema: public; Owner: pofenas
--

CREATE SEQUENCE public.zfx_user_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.zfx_user_id_seq OWNER TO pofenas;

--
-- Name: zfx_user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: pofenas
--

ALTER SEQUENCE public.zfx_user_id_seq OWNED BY public.zfx_user.id;


--
-- Name: zfx_userattribute; Type: TABLE; Schema: public; Owner: pofenas
--

CREATE TABLE public.zfx_userattribute (
    id_user integer NOT NULL,
    code character varying(256) NOT NULL,
    value text
);


ALTER TABLE public.zfx_userattribute OWNER TO pofenas;

--
-- Name: opciones id_opcion; Type: DEFAULT; Schema: public; Owner: pofenas
--

ALTER TABLE ONLY public.opciones ALTER COLUMN id_opcion SET DEFAULT nextval('public.opciones_id_opcion_seq'::regclass);


--
-- Name: ponencias id_ponencia; Type: DEFAULT; Schema: public; Owner: pofenas
--

ALTER TABLE ONLY public.ponencias ALTER COLUMN id_ponencia SET DEFAULT nextval('public.ponencias_id_seq'::regclass);


--
-- Name: preguntas id_pregunta; Type: DEFAULT; Schema: public; Owner: pofenas
--

ALTER TABLE ONLY public.preguntas ALTER COLUMN id_pregunta SET DEFAULT nextval('public.preguntas_id_pregunta_seq'::regclass);


--
-- Name: respuestas id_respuesta; Type: DEFAULT; Schema: public; Owner: pofenas
--

ALTER TABLE ONLY public.respuestas ALTER COLUMN id_respuesta SET DEFAULT nextval('public.respuestas_id_respuesta_seq'::regclass);


--
-- Name: zfx_group id; Type: DEFAULT; Schema: public; Owner: pofenas
--

ALTER TABLE ONLY public.zfx_group ALTER COLUMN id SET DEFAULT nextval('public.zfx_group_id_seq'::regclass);


--
-- Name: zfx_permission id; Type: DEFAULT; Schema: public; Owner: pofenas
--

ALTER TABLE ONLY public.zfx_permission ALTER COLUMN id SET DEFAULT nextval('public.zfx_permission_id_seq'::regclass);


--
-- Name: zfx_user id; Type: DEFAULT; Schema: public; Owner: pofenas
--

ALTER TABLE ONLY public.zfx_user ALTER COLUMN id SET DEFAULT nextval('public.zfx_user_id_seq'::regclass);


--
-- Data for Name: opciones; Type: TABLE DATA; Schema: public; Owner: pofenas
--

COPY public.opciones (id_opcion, id_pregunta, "opTexto", correcta) FROM stdin;
2	1	Respuesta B	f
3	1	Respuesta C	f
4	1	Respuesta D	f
5	2	Opcion A	f
7	2	Opcion C	f
8	2	Opcion D	f
9	3	Opcion 1	f
10	3	Opcion 2	f
12	3	Opcion 4	f
14	4	Op 2	f
15	4	Op 3	f
13	4	Op 1	f
1	1	respuesta A	t
6	2	Opcion B	t
11	3	Opcion 3	t
16	4	Op 4	t
17	5	cacacaca	f
\.


--
-- Data for Name: ponencias; Type: TABLE DATA; Schema: public; Owner: pofenas
--

COPY public.ponencias (id_ponencia, "Nombre", id_user, terminada) FROM stdin;
2	Ponencia de prueba 2(vacia)	1	t
1	Ponencia de prueba	1	t
\.


--
-- Data for Name: preguntas; Type: TABLE DATA; Schema: public; Owner: pofenas
--

COPY public.preguntas (id_pregunta, id_ponencia, texto, abierto, orden) FROM stdin;
1	1	¿Cual es tu contestacion a la primera pregunta?	f	1
2	1	¿Cual es tu contestacion a la segunda pregunta?	f	2
3	1	¿Cual es tu contestacion a la tercera pregunta?	f	3
4	1	¿Cual es tu contestacion a la cuarta pregunta?	f	4
5	2	caca	f	1
\.


--
-- Data for Name: respuestas; Type: TABLE DATA; Schema: public; Owner: pofenas
--

COPY public.respuestas (id_respuesta, id_pregunta, id_opcion, ip) FROM stdin;
137	1	2	192.168.1.35
138	2	7	192.168.1.35
139	3	10	192.168.1.35
140	4	14	192.168.1.35
\.


--
-- Data for Name: zfx_group; Type: TABLE DATA; Schema: public; Owner: pofenas
--

COPY public.zfx_group (id, name, description, ref1, ref2) FROM stdin;
1	u-admin	Grupo propio del usuario admin	\N	\N
2	ponentes	Ponentes	\N	\N
\.


--
-- Data for Name: zfx_group_permission; Type: TABLE DATA; Schema: public; Owner: pofenas
--

COPY public.zfx_group_permission (id_group, id_permission) FROM stdin;
1	1
1	2
1	3
2	4
\.


--
-- Data for Name: zfx_permission; Type: TABLE DATA; Schema: public; Owner: pofenas
--

COPY public.zfx_permission (id, code, description) FROM stdin;
1	menu-sis-cuentas-usuarios	Menú Sistema/Cuentas/Usuarios
2	menu-sis-cuentas-grupos	Menú Sistema/Cuentas/Grupos
3	menu-sis-cuentas-permisos	Menú Sistema/Cuentas/Permisos
4	ponentes	ponentes
\.


--
-- Data for Name: zfx_user; Type: TABLE DATA; Schema: public; Owner: pofenas
--

COPY public.zfx_user (id, login, password_hash, language, ref1, ref2) FROM stdin;
1	admin	21232f297a57a5a743894a0e4a801fc3	es	\N	\N
2	prueba	c893bad68927b457dbed39460e6afd62	es	\N	\N
3	ponente	21232f297a57a5a743894a0e4a801fc3	es	\N	\N
\.


--
-- Data for Name: zfx_user_group; Type: TABLE DATA; Schema: public; Owner: pofenas
--

COPY public.zfx_user_group (id_user, id_group) FROM stdin;
1	1
3	2
\.


--
-- Data for Name: zfx_userattribute; Type: TABLE DATA; Schema: public; Owner: pofenas
--

COPY public.zfx_userattribute (id_user, code, value) FROM stdin;
\.


--
-- Name: opciones_id_opcion_seq; Type: SEQUENCE SET; Schema: public; Owner: pofenas
--

SELECT pg_catalog.setval('public.opciones_id_opcion_seq', 17, true);


--
-- Name: ponencias_id_seq; Type: SEQUENCE SET; Schema: public; Owner: pofenas
--

SELECT pg_catalog.setval('public.ponencias_id_seq', 2, true);


--
-- Name: preguntas_id_pregunta_seq; Type: SEQUENCE SET; Schema: public; Owner: pofenas
--

SELECT pg_catalog.setval('public.preguntas_id_pregunta_seq', 5, true);


--
-- Name: respuestas_id_respuesta_seq; Type: SEQUENCE SET; Schema: public; Owner: pofenas
--

SELECT pg_catalog.setval('public.respuestas_id_respuesta_seq', 142, true);


--
-- Name: zfx_group_id_seq; Type: SEQUENCE SET; Schema: public; Owner: pofenas
--

SELECT pg_catalog.setval('public.zfx_group_id_seq', 2, true);


--
-- Name: zfx_permission_id_seq; Type: SEQUENCE SET; Schema: public; Owner: pofenas
--

SELECT pg_catalog.setval('public.zfx_permission_id_seq', 4, true);


--
-- Name: zfx_user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: pofenas
--

SELECT pg_catalog.setval('public.zfx_user_id_seq', 3, true);


--
-- Name: opciones opciones_pkey; Type: CONSTRAINT; Schema: public; Owner: pofenas
--

ALTER TABLE ONLY public.opciones
    ADD CONSTRAINT opciones_pkey PRIMARY KEY (id_opcion);


--
-- Name: ponencias ponencias_pkey; Type: CONSTRAINT; Schema: public; Owner: pofenas
--

ALTER TABLE ONLY public.ponencias
    ADD CONSTRAINT ponencias_pkey PRIMARY KEY (id_ponencia);


--
-- Name: preguntas preguntas_pkey; Type: CONSTRAINT; Schema: public; Owner: pofenas
--

ALTER TABLE ONLY public.preguntas
    ADD CONSTRAINT preguntas_pkey PRIMARY KEY (id_pregunta);


--
-- Name: respuestas respuestas_id_pregunta_ip; Type: CONSTRAINT; Schema: public; Owner: pofenas
--

ALTER TABLE ONLY public.respuestas
    ADD CONSTRAINT respuestas_id_pregunta_ip UNIQUE (id_pregunta, ip);


--
-- Name: respuestas respuestas_pkey; Type: CONSTRAINT; Schema: public; Owner: pofenas
--

ALTER TABLE ONLY public.respuestas
    ADD CONSTRAINT respuestas_pkey PRIMARY KEY (id_respuesta);


--
-- Name: zfx_group_permission zfx_group_permission_pkey; Type: CONSTRAINT; Schema: public; Owner: pofenas
--

ALTER TABLE ONLY public.zfx_group_permission
    ADD CONSTRAINT zfx_group_permission_pkey PRIMARY KEY (id_group, id_permission);


--
-- Name: zfx_group zfx_group_pkey; Type: CONSTRAINT; Schema: public; Owner: pofenas
--

ALTER TABLE ONLY public.zfx_group
    ADD CONSTRAINT zfx_group_pkey PRIMARY KEY (id);


--
-- Name: zfx_permission zfx_permission_code_key; Type: CONSTRAINT; Schema: public; Owner: pofenas
--

ALTER TABLE ONLY public.zfx_permission
    ADD CONSTRAINT zfx_permission_code_key UNIQUE (code);


--
-- Name: zfx_permission zfx_permission_pkey; Type: CONSTRAINT; Schema: public; Owner: pofenas
--

ALTER TABLE ONLY public.zfx_permission
    ADD CONSTRAINT zfx_permission_pkey PRIMARY KEY (id);


--
-- Name: zfx_user_group zfx_user_group_pkey; Type: CONSTRAINT; Schema: public; Owner: pofenas
--

ALTER TABLE ONLY public.zfx_user_group
    ADD CONSTRAINT zfx_user_group_pkey PRIMARY KEY (id_user, id_group);


--
-- Name: zfx_user zfx_user_name_key; Type: CONSTRAINT; Schema: public; Owner: pofenas
--

ALTER TABLE ONLY public.zfx_user
    ADD CONSTRAINT zfx_user_name_key UNIQUE (login);


--
-- Name: zfx_user zfx_user_pkey; Type: CONSTRAINT; Schema: public; Owner: pofenas
--

ALTER TABLE ONLY public.zfx_user
    ADD CONSTRAINT zfx_user_pkey PRIMARY KEY (id);


--
-- Name: zfx_userattribute zfx_userattribute_pkey; Type: CONSTRAINT; Schema: public; Owner: pofenas
--

ALTER TABLE ONLY public.zfx_userattribute
    ADD CONSTRAINT zfx_userattribute_pkey PRIMARY KEY (id_user, code);


--
-- Name: opciones opciones_id_pregunta_fkey; Type: FK CONSTRAINT; Schema: public; Owner: pofenas
--

ALTER TABLE ONLY public.opciones
    ADD CONSTRAINT opciones_id_pregunta_fkey FOREIGN KEY (id_pregunta) REFERENCES public.preguntas(id_pregunta) ON DELETE CASCADE;


--
-- Name: ponencias ponencias_id_user_fkey; Type: FK CONSTRAINT; Schema: public; Owner: pofenas
--

ALTER TABLE ONLY public.ponencias
    ADD CONSTRAINT ponencias_id_user_fkey FOREIGN KEY (id_user) REFERENCES public.zfx_user(id) ON DELETE CASCADE;


--
-- Name: preguntas preguntas_id_ponencia_fkey; Type: FK CONSTRAINT; Schema: public; Owner: pofenas
--

ALTER TABLE ONLY public.preguntas
    ADD CONSTRAINT preguntas_id_ponencia_fkey FOREIGN KEY (id_ponencia) REFERENCES public.ponencias(id_ponencia) ON DELETE CASCADE;


--
-- Name: respuestas respuestas_id_opcion_fkey; Type: FK CONSTRAINT; Schema: public; Owner: pofenas
--

ALTER TABLE ONLY public.respuestas
    ADD CONSTRAINT respuestas_id_opcion_fkey FOREIGN KEY (id_opcion) REFERENCES public.opciones(id_opcion) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: respuestas respuestas_id_pregunta_fkey; Type: FK CONSTRAINT; Schema: public; Owner: pofenas
--

ALTER TABLE ONLY public.respuestas
    ADD CONSTRAINT respuestas_id_pregunta_fkey FOREIGN KEY (id_pregunta) REFERENCES public.preguntas(id_pregunta) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: zfx_group_permission zfx_group_permission_relGroup; Type: FK CONSTRAINT; Schema: public; Owner: pofenas
--

ALTER TABLE ONLY public.zfx_group_permission
    ADD CONSTRAINT "zfx_group_permission_relGroup" FOREIGN KEY (id_group) REFERENCES public.zfx_group(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: zfx_group_permission zfx_group_permission_relPermission; Type: FK CONSTRAINT; Schema: public; Owner: pofenas
--

ALTER TABLE ONLY public.zfx_group_permission
    ADD CONSTRAINT "zfx_group_permission_relPermission" FOREIGN KEY (id_permission) REFERENCES public.zfx_permission(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: zfx_user_group zfx_user_group_relGroup; Type: FK CONSTRAINT; Schema: public; Owner: pofenas
--

ALTER TABLE ONLY public.zfx_user_group
    ADD CONSTRAINT "zfx_user_group_relGroup" FOREIGN KEY (id_group) REFERENCES public.zfx_group(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: zfx_user_group zfx_user_group_relUser; Type: FK CONSTRAINT; Schema: public; Owner: pofenas
--

ALTER TABLE ONLY public.zfx_user_group
    ADD CONSTRAINT "zfx_user_group_relUser" FOREIGN KEY (id_user) REFERENCES public.zfx_user(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: zfx_userattribute zfx_userattribute_relUser; Type: FK CONSTRAINT; Schema: public; Owner: pofenas
--

ALTER TABLE ONLY public.zfx_userattribute
    ADD CONSTRAINT "zfx_userattribute_relUser" FOREIGN KEY (id_user) REFERENCES public.zfx_user(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

