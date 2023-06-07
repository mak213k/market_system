--
-- PostgreSQL database dump
--

-- Dumped from database version 10.20
-- Dumped by pg_dump version 10.20

-- Started on 2023-06-07 07:39:44

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
-- TOC entry 1 (class 3079 OID 12924)
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- TOC entry 2853 (class 0 OID 0)
-- Dependencies: 1
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


--
-- TOC entry 198 (class 1259 OID 16454)
-- Name: id_product_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.id_product_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.id_product_seq OWNER TO postgres;

--
-- TOC entry 199 (class 1259 OID 16459)
-- Name: id_product_type_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.id_product_type_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.id_product_type_seq OWNER TO postgres;

--
-- TOC entry 205 (class 1259 OID 16503)
-- Name: id_sale_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.id_sale_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.id_sale_seq OWNER TO postgres;

--
-- TOC entry 201 (class 1259 OID 16466)
-- Name: id_tax_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.id_tax_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.id_tax_seq OWNER TO postgres;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 196 (class 1259 OID 16428)
-- Name: product; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.product (
    id_product integer NOT NULL,
    name character varying(60),
    description character varying(200),
    price numeric,
    create_at time without time zone DEFAULT now() NOT NULL,
    update_at time without time zone DEFAULT now(),
    product_type_id integer
);


ALTER TABLE public.product OWNER TO postgres;

--
-- TOC entry 2854 (class 0 OID 0)
-- Dependencies: 196
-- Name: TABLE product; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON TABLE public.product IS 'products tables';


--
-- TOC entry 204 (class 1259 OID 16498)
-- Name: product_sale; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.product_sale (
    id_product integer NOT NULL,
    id_sale integer,
    price numeric
);


ALTER TABLE public.product_sale OWNER TO postgres;

--
-- TOC entry 197 (class 1259 OID 16435)
-- Name: product_type; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.product_type (
    id_product_type integer NOT NULL,
    name character varying NOT NULL
);


ALTER TABLE public.product_type OWNER TO postgres;

--
-- TOC entry 202 (class 1259 OID 16487)
-- Name: product_type_tax; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.product_type_tax (
    id_product_type integer NOT NULL,
    id_tax integer NOT NULL
);


ALTER TABLE public.product_type_tax OWNER TO postgres;

--
-- TOC entry 203 (class 1259 OID 16492)
-- Name: sales; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sales (
    id_sale integer NOT NULL,
    update_at time without time zone DEFAULT now(),
    create_at time without time zone,
    deleted_at time without time zone
);


ALTER TABLE public.sales OWNER TO postgres;

--
-- TOC entry 200 (class 1259 OID 16461)
-- Name: tax; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tax (
    id_tax integer NOT NULL,
    description character varying(30) NOT NULL,
    tax_percentage double precision
);


ALTER TABLE public.tax OWNER TO postgres;

--
-- TOC entry 2836 (class 0 OID 16428)
-- Dependencies: 196
-- Data for Name: product; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.product (id_product, name, description, price, create_at, update_at, product_type_id) FROM stdin;
13	Melancia	Melancia	7	21:13:56.421508	21:13:56.421508	\N
14	maçã	maçã	16.65	21:17:31.121649	21:17:31.121649	8
15	pera	pera	15.77	10:51:35.459253	10:51:35.459253	24
\.


--
-- TOC entry 2844 (class 0 OID 16498)
-- Dependencies: 204
-- Data for Name: product_sale; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.product_sale (id_product, id_sale, price) FROM stdin;
\.


--
-- TOC entry 2837 (class 0 OID 16435)
-- Dependencies: 197
-- Data for Name: product_type; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.product_type (id_product_type, name) FROM stdin;
25	Higiene
9	teste9
5	teste8
24	Alimentos 1
7	teste8
18	wwwww1
23	aaaa
8	teste8
39	PAO
\.


--
-- TOC entry 2842 (class 0 OID 16487)
-- Dependencies: 202
-- Data for Name: product_type_tax; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.product_type_tax (id_product_type, id_tax) FROM stdin;
39	2
25	5
9	4
5	6
24	3
\.


--
-- TOC entry 2843 (class 0 OID 16492)
-- Dependencies: 203
-- Data for Name: sales; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.sales (id_sale, update_at, create_at, deleted_at) FROM stdin;
\.


--
-- TOC entry 2840 (class 0 OID 16461)
-- Dependencies: 200
-- Data for Name: tax; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tax (id_tax, description, tax_percentage) FROM stdin;
2	irpf	27.5
5	ir	20.530000000000001
7	teste	15.66
3	CSLL	30.5
1	abc	20.300000000000001
4	CSLL	15.66
6	teste	55.799999999999997
\.


--
-- TOC entry 2855 (class 0 OID 0)
-- Dependencies: 198
-- Name: id_product_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.id_product_seq', 15, true);


--
-- TOC entry 2856 (class 0 OID 0)
-- Dependencies: 199
-- Name: id_product_type_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.id_product_type_seq', 39, true);


--
-- TOC entry 2857 (class 0 OID 0)
-- Dependencies: 205
-- Name: id_sale_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.id_sale_seq', 1, false);


--
-- TOC entry 2858 (class 0 OID 0)
-- Dependencies: 201
-- Name: id_tax_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.id_tax_seq', 7, true);


--
-- TOC entry 2709 (class 2606 OID 16491)
-- Name: product_type_tax PRODUCT_TYPE_TAX_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.product_type_tax
    ADD CONSTRAINT "PRODUCT_TYPE_TAX_pkey" PRIMARY KEY (id_product_type, id_tax);


--
-- TOC entry 2711 (class 2606 OID 16497)
-- Name: sales SALE_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sales
    ADD CONSTRAINT "SALE_pkey" PRIMARY KEY (id_sale);


--
-- TOC entry 2707 (class 2606 OID 16465)
-- Name: tax TAX_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tax
    ADD CONSTRAINT "TAX_pkey" PRIMARY KEY (id_tax);


--
-- TOC entry 2703 (class 2606 OID 16434)
-- Name: product pk_id_product; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.product
    ADD CONSTRAINT pk_id_product PRIMARY KEY (id_product);


--
-- TOC entry 2705 (class 2606 OID 16439)
-- Name: product_type product_type_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.product_type
    ADD CONSTRAINT product_type_pkey PRIMARY KEY (id_product_type);


--
-- TOC entry 2713 (class 2606 OID 16502)
-- Name: product_sale uk_product_sale; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.product_sale
    ADD CONSTRAINT uk_product_sale UNIQUE (id_product, id_sale);


--
-- TOC entry 2714 (class 2606 OID 16482)
-- Name: product fk_product_type_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.product
    ADD CONSTRAINT fk_product_type_id FOREIGN KEY (product_type_id) REFERENCES public.product_type(id_product_type);


-- Completed on 2023-06-07 07:39:45

--
-- PostgreSQL database dump complete
--

