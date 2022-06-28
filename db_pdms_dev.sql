--
-- PostgreSQL database dump
--

-- Dumped from database version 12.10 (Ubuntu 12.10-1.pgdg20.04+1)
-- Dumped by pg_dump version 12.10 (Ubuntu 12.10-1.pgdg20.04+1)

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
-- Name: getdateendincome(); Type: FUNCTION; Schema: public; Owner: whoami
--

CREATE FUNCTION public.getdateendincome() RETURNS date
    LANGUAGE plpgsql
    AS $$
declare
hasil date;
begin
hasil = (SELECT date FROM incomes ORDER BY date DESC LIMIT 1);
return hasil;
end;
$$;


ALTER FUNCTION public.getdateendincome() OWNER TO whoami;

--
-- Name: set_null_category_id(); Type: FUNCTION; Schema: public; Owner: whoami
--

CREATE FUNCTION public.set_null_category_id() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
	UPDATE products SET category_id = null WHERE category_id = OLD.id;
RETURN NEW;
END;
$$;


ALTER FUNCTION public.set_null_category_id() OWNER TO whoami;

--
-- Name: total_income(double precision, integer); Type: FUNCTION; Schema: public; Owner: whoami
--

CREATE FUNCTION public.total_income(price double precision, jumlah integer) RETURNS double precision
    LANGUAGE plpgsql
    AS $$
DECLARE
total double precision;
BEGIN
total = price * jumlah;
RETURN total;
END;
$$;


ALTER FUNCTION public.total_income(price double precision, jumlah integer) OWNER TO whoami;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: categories; Type: TABLE; Schema: public; Owner: whoami
--

CREATE TABLE public.categories (
    id character varying(50) NOT NULL,
    name character varying NOT NULL,
    company_id character varying NOT NULL,
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone
);


ALTER TABLE public.categories OWNER TO whoami;

--
-- Name: companys; Type: TABLE; Schema: public; Owner: whoami
--

CREATE TABLE public.companys (
    id character varying(50) NOT NULL,
    name character varying(50) NOT NULL,
    owner character varying(50) NOT NULL,
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone
);


ALTER TABLE public.companys OWNER TO whoami;

--
-- Name: expenditures; Type: TABLE; Schema: public; Owner: whoami
--

CREATE TABLE public.expenditures (
    id character varying(50) NOT NULL,
    date date NOT NULL,
    name character varying NOT NULL,
    price double precision NOT NULL,
    total_product integer NOT NULL,
    total_expenditure double precision NOT NULL,
    shop_id character varying NOT NULL,
    company_id character varying NOT NULL,
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone
);


ALTER TABLE public.expenditures OWNER TO whoami;

--
-- Name: incomes; Type: TABLE; Schema: public; Owner: whoami
--

CREATE TABLE public.incomes (
    id character varying(50) NOT NULL,
    date date NOT NULL,
    id_product character varying NOT NULL,
    total_product integer NOT NULL,
    total_income double precision NOT NULL,
    shop_id character varying NOT NULL,
    company_id character varying NOT NULL,
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone
);


ALTER TABLE public.incomes OWNER TO whoami;

--
-- Name: pgmigrations; Type: TABLE; Schema: public; Owner: whoami
--

CREATE TABLE public.pgmigrations (
    id integer NOT NULL,
    name character varying(255) NOT NULL,
    run_on timestamp without time zone NOT NULL
);


ALTER TABLE public.pgmigrations OWNER TO whoami;

--
-- Name: pgmigrations_id_seq; Type: SEQUENCE; Schema: public; Owner: whoami
--

CREATE SEQUENCE public.pgmigrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.pgmigrations_id_seq OWNER TO whoami;

--
-- Name: pgmigrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: whoami
--

ALTER SEQUENCE public.pgmigrations_id_seq OWNED BY public.pgmigrations.id;


--
-- Name: products; Type: TABLE; Schema: public; Owner: whoami
--

CREATE TABLE public.products (
    id character varying(50) NOT NULL,
    name character varying NOT NULL,
    category_id character varying,
    company_id character varying NOT NULL,
    price double precision NOT NULL,
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone
);


ALTER TABLE public.products OWNER TO whoami;

--
-- Name: role_users; Type: TABLE; Schema: public; Owner: whoami
--

CREATE TABLE public.role_users (
    id character varying(50) NOT NULL,
    name character varying(50) NOT NULL,
    role_access text NOT NULL,
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone
);


ALTER TABLE public.role_users OWNER TO whoami;

--
-- Name: shops; Type: TABLE; Schema: public; Owner: whoami
--

CREATE TABLE public.shops (
    id character varying(50) NOT NULL,
    name character varying NOT NULL,
    location character varying NOT NULL,
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone,
    admin_id character varying(50),
    company_id character varying(50)
);


ALTER TABLE public.shops OWNER TO whoami;

--
-- Name: users; Type: TABLE; Schema: public; Owner: whoami
--

CREATE TABLE public.users (
    id character varying(50) NOT NULL,
    fullname text NOT NULL,
    username character varying(50) NOT NULL,
    email character varying NOT NULL,
    password character varying NOT NULL,
    role_id character varying NOT NULL,
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone,
    owner character varying(50),
    company_id character varying(50)
);


ALTER TABLE public.users OWNER TO whoami;

--
-- Name: pgmigrations id; Type: DEFAULT; Schema: public; Owner: whoami
--

ALTER TABLE ONLY public.pgmigrations ALTER COLUMN id SET DEFAULT nextval('public.pgmigrations_id_seq'::regclass);


--
-- Data for Name: categories; Type: TABLE DATA; Schema: public; Owner: whoami
--

COPY public.categories (id, name, company_id, created_at, updated_at) FROM stdin;
CT0622001	laptop	CP0722001	2022-06-22 19:27:05	2022-06-22 19:27:05
CT0622003	keyboards	CP0722001	2022-06-22 19:52:00	2022-06-22 19:52:08
\.


--
-- Data for Name: companys; Type: TABLE DATA; Schema: public; Owner: whoami
--

COPY public.companys (id, name, owner, created_at, updated_at) FROM stdin;
CP0722001	Toko HP Zero 2	AP0622001	2022-06-17 21:33:23.141558	2022-06-22 19:51:41
\.


--
-- Data for Name: expenditures; Type: TABLE DATA; Schema: public; Owner: whoami
--

COPY public.expenditures (id, date, name, price, total_product, total_expenditure, shop_id, company_id, created_at, updated_at) FROM stdin;
EX0622002	2022-06-26	lem	10000	10	100000	TK0622004	CP0722001	2022-06-27 18:01:10	2022-06-27 18:01:10
EX0622003	2022-05-31	meja	100000	2	200000	TK0622003	CP0722001	2022-06-28 08:58:01	2022-06-28 08:58:01
\.


--
-- Data for Name: incomes; Type: TABLE DATA; Schema: public; Owner: whoami
--

COPY public.incomes (id, date, id_product, total_product, total_income, shop_id, company_id, created_at, updated_at) FROM stdin;
IC0622001	2022-06-01	PR0622003	1	6500000	TK0622003	CP0722001	2022-06-25 15:34:13	2022-06-25 15:34:13
IC0622002	2022-06-25	PR0622002	2	700000	TK0622003	CP0722001	2022-06-25 15:34:28	2022-06-25 15:34:28
IC0622003	2022-06-25	PR0622001	2	2000000	TK0622004	CP0722001	2022-06-25 20:57:36	2022-06-25 20:57:36
IC0622004	2022-06-19	PR0622002	1	350000	TK0622003	CP0722001	2022-06-25 22:21:12	2022-06-25 22:21:12
IC0622005	2022-06-22	PR0622001	1	1000000	TK0622003	CP0722001	2022-06-25 22:21:35	2022-06-25 22:21:35
IC0622006	2022-06-18	PR0622001	1	1000000	TK0622003	CP0722001	2022-06-25 22:21:50	2022-06-25 22:21:50
\.


--
-- Data for Name: pgmigrations; Type: TABLE DATA; Schema: public; Owner: whoami
--

COPY public.pgmigrations (id, name, run_on) FROM stdin;
36	1649556266144_create-table-user	2022-06-17 21:08:14.996665
37	1649556758726_create-table-shops	2022-06-17 21:08:14.996665
38	1649923135047_create-table-role-users	2022-06-17 21:08:14.996665
39	1649923212071_add-foreign-key-to-role-id-user	2022-06-17 21:08:14.996665
40	1649992494458_add-column-company-id-for-users	2022-06-17 21:08:14.996665
41	1650167968766_create-table-companys	2022-06-17 21:08:14.996665
42	1650168482933_add-column-admin-id-for-shops	2022-06-17 21:08:14.996665
43	1650168654482_add-foreign-key-for-users-and-shops	2022-06-17 21:08:14.996665
44	1652618742250_create-table-categories	2022-06-17 21:08:14.996665
45	1652713543259_create-table-products	2022-06-17 21:08:14.996665
46	1654152258382_create-table-incomes	2022-06-17 21:08:14.996665
47	1655132155362_create-table-expenditures	2022-06-17 21:08:14.996665
\.


--
-- Data for Name: products; Type: TABLE DATA; Schema: public; Owner: whoami
--

COPY public.products (id, name, category_id, company_id, price, created_at, updated_at) FROM stdin;
PR0622001	redmi note 8		CP0722001	1000000	2022-06-22 19:52:50	2022-06-22 19:52:50
PR0622002	ks20 sv	CT0622003	CP0722001	350000	2022-06-22 20:03:15	2022-06-22 20:03:15
PR0622003	laptop lenovo thinkpad t470s 8/500GB i7 6600U	CT0622001	CP0722001	6500000	2022-06-25 15:15:41	2022-06-25 15:15:41
\.


--
-- Data for Name: role_users; Type: TABLE DATA; Schema: public; Owner: whoami
--

COPY public.role_users (id, name, role_access, created_at, updated_at) FROM stdin;
777	root	root	2022-06-17 21:17:32.563554	2022-06-17 21:17:32.563554
775	admin	admin	2022-06-17 21:18:04.709327	2022-06-17 21:18:04.709327
\.


--
-- Data for Name: shops; Type: TABLE DATA; Schema: public; Owner: whoami
--

COPY public.shops (id, name, location, created_at, updated_at, admin_id, company_id) FROM stdin;
TK0622003	cabang cempak mas lt 3	jakarta pusat	2022-06-22 19:53:29	2022-06-24 18:34:09	\N	CP0722001
TK0622004	Cabang Mangga Dua Mall	Jakarta Utara	2022-06-25 20:57:16	2022-06-25 20:57:16	AP0622002	CP0722001
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: whoami
--

COPY public.users (id, fullname, username, email, password, role_id, created_at, updated_at, owner, company_id) FROM stdin;
AP0622001	whoami	whoami	whoami@gmail.com	d04b6497deeba354094ad86c2a32fddc1094f03d7d9baf0da7c9ffc9ca61e9d3	777	2022-06-17 21:27:09	2022-06-26 00:20:56	\N	CP0722001
AP0622002	nanang	nanang	nanang@gmail.com	240be518fabd2724ddb6f04eeb1da5967448d7e831c08c8fa822809f74c720a9	775	2022-06-28 15:06:19	2022-06-28 15:06:19	AP0622001	CP0722001
\.


--
-- Name: pgmigrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: whoami
--

SELECT pg_catalog.setval('public.pgmigrations_id_seq', 47, true);


--
-- Name: categories categories_pkey; Type: CONSTRAINT; Schema: public; Owner: whoami
--

ALTER TABLE ONLY public.categories
    ADD CONSTRAINT categories_pkey PRIMARY KEY (id);


--
-- Name: companys companys_pkey; Type: CONSTRAINT; Schema: public; Owner: whoami
--

ALTER TABLE ONLY public.companys
    ADD CONSTRAINT companys_pkey PRIMARY KEY (id);


--
-- Name: expenditures expenditures_pkey; Type: CONSTRAINT; Schema: public; Owner: whoami
--

ALTER TABLE ONLY public.expenditures
    ADD CONSTRAINT expenditures_pkey PRIMARY KEY (id);


--
-- Name: incomes incomes_pkey; Type: CONSTRAINT; Schema: public; Owner: whoami
--

ALTER TABLE ONLY public.incomes
    ADD CONSTRAINT incomes_pkey PRIMARY KEY (id);


--
-- Name: pgmigrations pgmigrations_pkey; Type: CONSTRAINT; Schema: public; Owner: whoami
--

ALTER TABLE ONLY public.pgmigrations
    ADD CONSTRAINT pgmigrations_pkey PRIMARY KEY (id);


--
-- Name: products products_pkey; Type: CONSTRAINT; Schema: public; Owner: whoami
--

ALTER TABLE ONLY public.products
    ADD CONSTRAINT products_pkey PRIMARY KEY (id);


--
-- Name: role_users role_users_pkey; Type: CONSTRAINT; Schema: public; Owner: whoami
--

ALTER TABLE ONLY public.role_users
    ADD CONSTRAINT role_users_pkey PRIMARY KEY (id);


--
-- Name: shops shops_pkey; Type: CONSTRAINT; Schema: public; Owner: whoami
--

ALTER TABLE ONLY public.shops
    ADD CONSTRAINT shops_pkey PRIMARY KEY (id);


--
-- Name: users users_email_key; Type: CONSTRAINT; Schema: public; Owner: whoami
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_key UNIQUE (email);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: whoami
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: users users_username_key; Type: CONSTRAINT; Schema: public; Owner: whoami
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_username_key UNIQUE (username);


--
-- Name: expenditures expenditures_company_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: whoami
--

ALTER TABLE ONLY public.expenditures
    ADD CONSTRAINT expenditures_company_id_fkey FOREIGN KEY (company_id) REFERENCES public.companys(id) ON DELETE CASCADE;


--
-- Name: expenditures expenditures_shop_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: whoami
--

ALTER TABLE ONLY public.expenditures
    ADD CONSTRAINT expenditures_shop_id_fkey FOREIGN KEY (shop_id) REFERENCES public.shops(id) ON DELETE CASCADE;


--
-- Name: categories fk_categories.company_id_role_companys.id; Type: FK CONSTRAINT; Schema: public; Owner: whoami
--

ALTER TABLE ONLY public.categories
    ADD CONSTRAINT "fk_categories.company_id_role_companys.id" FOREIGN KEY (company_id) REFERENCES public.companys(id) ON DELETE CASCADE;


--
-- Name: companys fk_companys.owner_role_users.id; Type: FK CONSTRAINT; Schema: public; Owner: whoami
--

ALTER TABLE ONLY public.companys
    ADD CONSTRAINT "fk_companys.owner_role_users.id" FOREIGN KEY (owner) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: incomes fk_incomes.company_id_role_companys.id; Type: FK CONSTRAINT; Schema: public; Owner: whoami
--

ALTER TABLE ONLY public.incomes
    ADD CONSTRAINT "fk_incomes.company_id_role_companys.id" FOREIGN KEY (company_id) REFERENCES public.companys(id) ON DELETE CASCADE;


--
-- Name: incomes fk_incomes.id_product_role_products.id; Type: FK CONSTRAINT; Schema: public; Owner: whoami
--

ALTER TABLE ONLY public.incomes
    ADD CONSTRAINT "fk_incomes.id_product_role_products.id" FOREIGN KEY (id_product) REFERENCES public.products(id) ON DELETE CASCADE;


--
-- Name: incomes fk_incomes.shop_id_role_shops.id; Type: FK CONSTRAINT; Schema: public; Owner: whoami
--

ALTER TABLE ONLY public.incomes
    ADD CONSTRAINT "fk_incomes.shop_id_role_shops.id" FOREIGN KEY (shop_id) REFERENCES public.shops(id) ON DELETE CASCADE;


--
-- Name: products fk_products.company_id_role_companys.id; Type: FK CONSTRAINT; Schema: public; Owner: whoami
--

ALTER TABLE ONLY public.products
    ADD CONSTRAINT "fk_products.company_id_role_companys.id" FOREIGN KEY (company_id) REFERENCES public.companys(id) ON DELETE CASCADE;


--
-- Name: shops fk_shops.company_id_role_companys.id; Type: FK CONSTRAINT; Schema: public; Owner: whoami
--

ALTER TABLE ONLY public.shops
    ADD CONSTRAINT "fk_shops.company_id_role_companys.id" FOREIGN KEY (company_id) REFERENCES public.companys(id) ON DELETE CASCADE;


--
-- Name: companys fk_update_companys.owner_role_users.id; Type: FK CONSTRAINT; Schema: public; Owner: whoami
--

ALTER TABLE ONLY public.companys
    ADD CONSTRAINT "fk_update_companys.owner_role_users.id" FOREIGN KEY (owner) REFERENCES public.users(id) ON UPDATE CASCADE;


--
-- Name: users fk_users.company_id_role_companys.id; Type: FK CONSTRAINT; Schema: public; Owner: whoami
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT "fk_users.company_id_role_companys.id" FOREIGN KEY (company_id) REFERENCES public.companys(id) ON DELETE CASCADE;


--
-- Name: users fk_users.role_id_role_users.id; Type: FK CONSTRAINT; Schema: public; Owner: whoami
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT "fk_users.role_id_role_users.id" FOREIGN KEY (role_id) REFERENCES public.role_users(id) ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

