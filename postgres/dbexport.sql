--
-- PostgreSQL database dump
--

-- Dumped from database version 15.2
-- Dumped by pg_dump version 15.2

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

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: ANNUNCIO; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."ANNUNCIO" (
    "Data" date NOT NULL,
    "Ora" time without time zone NOT NULL,
    "Telefono" character varying(10) NOT NULL,
    "Testo" character varying(1024) NOT NULL
);


ALTER TABLE public."ANNUNCIO" OWNER TO postgres;

--
-- Name: IMMAGINE_L; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."IMMAGINE_L" (
    "ID_L" integer NOT NULL,
    "Nome" character varying(15) NOT NULL
);


ALTER TABLE public."IMMAGINE_L" OWNER TO postgres;

--
-- Name: IMMAGINE_P; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."IMMAGINE_P" (
    "ID_P" integer NOT NULL,
    "Nome" character varying(15) NOT NULL
);


ALTER TABLE public."IMMAGINE_P" OWNER TO postgres;

--
-- Name: LAVORO; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."LAVORO" (
    "ID" integer NOT NULL,
    "Titolo" character varying(25) NOT NULL,
    "Data" date NOT NULL,
    "Descrizione" character varying(1024) NOT NULL,
    "Telefono" character(10)
);


ALTER TABLE public."LAVORO" OWNER TO postgres;

--
-- Name: LAVORO_ID_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public."LAVORO_ID_seq"
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."LAVORO_ID_seq" OWNER TO postgres;

--
-- Name: LAVORO_ID_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public."LAVORO_ID_seq" OWNED BY public."LAVORO"."ID";


--
-- Name: PRENOTAZIONE; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."PRENOTAZIONE" (
    "Telefono_C" character(10) NOT NULL,
    "Data_P" date NOT NULL,
    "Ora_P" time without time zone NOT NULL,
    "Telefono_P" character(10) NOT NULL
);


ALTER TABLE public."PRENOTAZIONE" OWNER TO postgres;

--
-- Name: PRENOTAZIONE_TRATTAMENTO; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."PRENOTAZIONE_TRATTAMENTO" (
    "Telefono_C" character(10) NOT NULL,
    "Data_P" date NOT NULL,
    "Ora_P" time without time zone NOT NULL,
    "ID_T" integer NOT NULL
);


ALTER TABLE public."PRENOTAZIONE_TRATTAMENTO" OWNER TO postgres;

--
-- Name: PRODOTTO; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."PRODOTTO" (
    "ID" integer NOT NULL,
    "Nome" character varying(25) NOT NULL,
    "Prezzo" money NOT NULL,
    "Descrizione" character varying(1024) NOT NULL,
    "Telefono" character varying(10)
);


ALTER TABLE public."PRODOTTO" OWNER TO postgres;

--
-- Name: PRODOTTO_ID_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public."PRODOTTO_ID_seq"
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."PRODOTTO_ID_seq" OWNER TO postgres;

--
-- Name: PRODOTTO_ID_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public."PRODOTTO_ID_seq" OWNED BY public."PRODOTTO"."ID";


--
-- Name: RECENSIONE; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."RECENSIONE" (
    "Telefono" character(10) NOT NULL,
    "Data_P" date NOT NULL,
    "Ora_P" time without time zone NOT NULL,
    "Data" date NOT NULL,
    "Ora" time without time zone NOT NULL,
    "Rating" smallint NOT NULL,
    "Testo" character varying(1024) NOT NULL,
    CONSTRAINT "Rating_check" CHECK ((("Rating" >= 1) AND ("Rating" <= 5)))
);


ALTER TABLE public."RECENSIONE" OWNER TO postgres;

--
-- Name: TRATTAMENTO; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."TRATTAMENTO" (
    "ID" integer NOT NULL,
    "Titolo" character varying(25) NOT NULL,
    "Durata" interval NOT NULL,
    "Prezzo" money NOT NULL,
    "Surplus" money NOT NULL,
    "Descrizione" character varying(1024) NOT NULL,
    "Telefono" character(10)
);


ALTER TABLE public."TRATTAMENTO" OWNER TO postgres;

--
-- Name: TRATTAMENTO_ID_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public."TRATTAMENTO_ID_seq"
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."TRATTAMENTO_ID_seq" OWNER TO postgres;

--
-- Name: TRATTAMENTO_ID_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public."TRATTAMENTO_ID_seq" OWNED BY public."TRATTAMENTO"."ID";


--
-- Name: UTENTE; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."UTENTE" (
    "Telefono" character(10) NOT NULL,
    "Username" character varying(20) NOT NULL,
    "PSW" character(60) NOT NULL,
    "Email" character varying NOT NULL,
    "Nome" character varying(15) NOT NULL,
    "Cognome" character varying(15) NOT NULL,
    "Tipologia" boolean DEFAULT false,
    "Logged" boolean DEFAULT false,
    "Token" character varying(50)
);


ALTER TABLE public."UTENTE" OWNER TO postgres;

--
-- Name: VISIT; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."VISIT" (
    id integer NOT NULL,
    ip_address inet,
    "timestamp" timestamp without time zone,
    CONSTRAINT "VISIT_ip_address_check" CHECK ((family(ip_address) = 4))
);


ALTER TABLE public."VISIT" OWNER TO postgres;

--
-- Name: VISIT_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public."VISIT_id_seq"
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."VISIT_id_seq" OWNER TO postgres;

--
-- Name: VISIT_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public."VISIT_id_seq" OWNED BY public."VISIT".id;


--
-- Name: LAVORO ID; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."LAVORO" ALTER COLUMN "ID" SET DEFAULT nextval('public."LAVORO_ID_seq"'::regclass);


--
-- Name: PRODOTTO ID; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."PRODOTTO" ALTER COLUMN "ID" SET DEFAULT nextval('public."PRODOTTO_ID_seq"'::regclass);


--
-- Name: TRATTAMENTO ID; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."TRATTAMENTO" ALTER COLUMN "ID" SET DEFAULT nextval('public."TRATTAMENTO_ID_seq"'::regclass);


--
-- Name: VISIT id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."VISIT" ALTER COLUMN id SET DEFAULT nextval('public."VISIT_id_seq"'::regclass);


--
-- Data for Name: ANNUNCIO; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public."ANNUNCIO" ("Data", "Ora", "Telefono", "Testo") FROM stdin;
2023-06-28	17:14:00	3213234539	Hai bisogno di un nuovo look per l'estate? Approfitta della nostra offerta speciale e prenota un taglio e piega a soli 25€! I nostri esperti hair stylist saranno a tua disposizione per consigliarti lo stile più adatto al tuo viso e alla tua personalità. Non perdere l'occasione di rinnovare il tuo look nel nostro salone di bellezza!
2023-06-28	17:15:34	3213234539	Vuoi avere capelli morbidi e luminosi senza dover ricorrere al parrucchiere ogni settimana? Prova il nostro trattamento alla cheratina! Grazie alla formula naturale a base di cheratina e aminoacidi, i tuoi capelli saranno nutriti in profondità e resi più forti e luminosi. Prenota subito il tuo appuntamento e goditi i vantaggi del trattamento alla cheratina nel nostro salone di bellezza.
2023-06-28	17:15:49	3213234539	Vuoi cambiare colore ai tuoi capelli senza sembrare finta? Prova la tecnica dei riflessi! Grazie alla combinazione di tonalità diverse, i tuoi capelli avranno un effetto naturale e luminoso che farà invidia a tutti. I nostri esperti hair stylist saranno a tua disposizione per consigliarti la soluzione più adatta al tuo stile e alla tua personalità. Prenota subito il tuo trattamento colore e riflessi nel nostro salone di bellezza.
2023-06-28	17:23:06	3213234539	I tuoi capelli sono danneggiati dal sole, dal cloro o dal calore degli strumenti di styling? Prova il nostro trattamento riparatore! Grazie alla formula a base di oli essenziali e proteine, i tuoi capelli saranno idratati e rinforzati, riparando i danni e prevenendone la ricomparsa. Prenota subito il tuo trattamento riparatore e goditi capelli sani e forti nel nostro salone di bellezza.
2023-06-28	17:23:24	3213234539	Hai bisogno di un taglio uomo che si adatti alle tue esigenze? Prova il nostro servizio di taglio personalizzato! Grazie alla consulenza dei nostri esperti hair stylist, troverai lo stile perfetto per ogni occasione, dal look formale al casual. Inoltre, potrai scegliere tra una vasta gamma di prodotti per lo styling per avere sempre i tuoi capelli al top. Prenota subito il tuo taglio uomo nel nostro salone di bellezza.
\.


--
-- Data for Name: IMMAGINE_L; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public."IMMAGINE_L" ("ID_L", "Nome") FROM stdin;
1	1
2	1
3	1
4	1
6	1
7	1
5	1
15	1
15	2
15	3
\.


--
-- Data for Name: IMMAGINE_P; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public."IMMAGINE_P" ("ID_P", "Nome") FROM stdin;
1	front
2	front
3	front
4	front
5	front
6	front
7	front
8	front
9	front
10	front
11	front
12	front
13	front
14	front
15	front
16	front
17	front
18	front
19	front
\.


--
-- Data for Name: LAVORO; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public."LAVORO" ("ID", "Titolo", "Data", "Descrizione", "Telefono") FROM stdin;
1	Biondo Platino	2023-03-23	Lavoro per la Sig.ra Maria	3213234532
2	Stabilizzazione	2023-04-12	Lavoro per la Sig.ra Cristina	3213234532
3	Boccolo Oro	2023-02-16	Lavoro per la Sig.ra Fabiana	3213234532
4	Ricciolo Oro	2023-02-16	Lavoro per la Sig.ra Martina	3213234532
5	Ricciolo Rame	2023-05-12	Lavoro per la Sig.ra Maria Pia	3213234532
6	Castano Chic	2023-05-12	Lavoro per la Sig.ra Rosanna	3213234532
7	Lavoro favoloso	2023-06-11	Lavoro per la sig.Fabiana	3213234532
15	Biondo Chic	2023-06-30	Lavoro per la sig. Antonella	3213234539
\.


--
-- Data for Name: PRENOTAZIONE; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public."PRENOTAZIONE" ("Telefono_C", "Data_P", "Ora_P", "Telefono_P") FROM stdin;
3221254865	2023-05-17	17:30:00	3213234539
3241234865	2023-05-18	14:30:00	3213234539
3241254865	2023-05-20	16:30:00	3213234539
\.


--
-- Data for Name: PRENOTAZIONE_TRATTAMENTO; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public."PRENOTAZIONE_TRATTAMENTO" ("Telefono_C", "Data_P", "Ora_P", "ID_T") FROM stdin;
3221254865	2023-05-17	17:30:00	1
3241234865	2023-05-18	14:30:00	3
3241254865	2023-05-20	16:30:00	1
3241254865	2023-05-20	16:30:00	2
3241254865	2023-05-20	16:30:00	3
\.


--
-- Data for Name: PRODOTTO; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public."PRODOTTO" ("ID", "Nome", "Prezzo", "Descrizione", "Telefono") FROM stdin;
1	Illuminante	17,60 €	Illuminante Setificante Bifasico	3213234532
2	Shampoo	17,10 €	Shampoo Antigiallo	3213234532
3	Maschera	19,10 €	Maschera protettiva illuminante	3213234532
4	Maschera	17,10 €	Dermo-calm maschera dermoequilibrante	3213234532
5	Detergente	16,10 €	Latte detergente dermoequilibrante	3213234532
6	Condizionante	17,10 €	Condizionante per capelli indisciplinati	3213234532
7	Laminazione	45,00 €	Prodotti per laminazione non vendibili singolarmente 	3213234532
8	Mousse	17,00 €	Mousse capelli ricci	3213234532
9	Lacca	15,00 €	Lacca volumizzante	3213234532
10	Tinta	10,00 €	Tinta fondonatura	3213234532
11	Tinta	11,00 €	Tinta Oreal	3213234532
12	Riflessante	12,00 €	Riflessante oreal	3213234532
13	Anticaduta	57,60 €	Cura Anticaduta Fondonatura	3213234532
14	Anticaduta	13,00 €	S. H. Anticaduta Fondonatura	3213234532
15	Gel	15,00 €	Gel Fondonatura	3213234532
16	Permanente	15,00 €	Permanente oreal, non vendibili	3213234532
17	Ossigeno	15,00 €	Ossigeno vari volumi per colorazione	3213234532
18	Decolorante	30,00 €	Decolorante per meches framesi	3213234532
19	Spray	15,00 €	Spray perfezionatore multiuso	3213234532
\.


--
-- Data for Name: RECENSIONE; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public."RECENSIONE" ("Telefono", "Data_P", "Ora_P", "Data", "Ora", "Rating", "Testo") FROM stdin;
3221254865	2023-05-17	17:30:00	2023-05-20	12:00:00	5	Non potrei essere più soddisfatta della mia esperienza al Margherita Salon. Ho optato per una piega corta e il risultato è stato semplicemente fantastico. Lo staff è stato incredibilmente professionale, attento ad ogni dettaglio e ha saputo creare esattamente il look che desideravo. Oltre alla competenza, ho apprezzato l\\'atmosfera accogliente e il servizio impeccabile. Consiglio vivamente Margherita Salon a chiunque desideri un trattamento di bellezza di altissimo livello. Non vedo l\\'ora di tornarci!
3241234865	2023-05-18	14:30:00	2023-05-21	11:00:00	5	Sono rimasta estremamente soddisfatta della mia esperienza al Margherita Salon. Ho deciso di provare un nuovo taglio di capelli e devo dire che il risultato è stato fantastico. Lo staff è stato gentile e professionale, ascoltando attentamente le mie richieste e offrendo consigli utili. Il parrucchiere ha dimostrato grande abilità nel realizzare il taglio desiderato, creando una forma armoniosa che si adatta perfettamente al mio viso.
3241254865	2023-05-20	16:30:00	2023-05-21	09:30:00	3	\nLa mia piega corta al Margherita Salon è stata discreta. Il risultato era accettabile, ma non eccezionale. Servizio e ambiente buoni.
\.


--
-- Data for Name: TRATTAMENTO; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public."TRATTAMENTO" ("ID", "Titolo", "Durata", "Prezzo", "Surplus", "Descrizione", "Telefono") FROM stdin;
1	Piega Corta	00:30:00	10,00 €	5,00 €	Nothing	3213234532
2	Piega Media	00:30:00	13,00 €	5,00 €	Nothing	3213234532
4	Taglio	00:30:00	12,00 €	5,00 €	Per capelli asciutti	3213234532
5	Permanente	01:00:00	30,00 €	10,00 €	Per capelli corti	3213234532
6	Stiraggio	01:00:00	30,00 €	10,00 €	Per capelli corti	3213234532
7	Colore	01:30:00	25,00 €	10,00 €	Per capelli corti	3213234532
8	Meches	01:20:00	30,00 €	10,00 €	Per capelli corti	3213234532
9	Colpi di Sole	00:45:00	30,00 €	10,00 €	Per capelli corti	3213234532
10	Riflessante	00:45:00	23,00 €	5,00 €	Per capelli corti	3213234532
13	Shampoo	00:05:00	2,00 €	0,00 €		3213234532
14	Lozione fissativa	00:10:00	2,00 €	0,00 €		3213234532
15	Impacco Ristrutturante	00:10:00	4,00 €	0,00 €		3213234532
18	Ritocco colore	00:35:00	10,00 €	0,00 €		3213234532
19	Piastra	00:45:00	4,00 €	0,00 €		3213234532
20	Balsamo	00:15:00	1,00 €	0,00 €		3213234532
3	Taglio (Capelli corti)	00:30:00	12,00 €	0,00 €	Per capelli corti	3213234532
11	Piega (Per bambini)	00:30:00	10,00 €	5,00 €	Per bambini fino a 6 anni	3213234532
12	Shampoo (Specifico)	00:05:00	2,00 €	0,00 €	Shampoo specifico	3213234532
16	Pettinata (phon)	00:25:00	7,00 €	0,00 €	Con Phon	3213234532
17	Pettinata (capelli umidi)	00:25:00	9,00 €	0,00 €	Capelli umidi	3213234532
\.


--
-- Data for Name: UTENTE; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public."UTENTE" ("Telefono", "Username", "PSW", "Email", "Nome", "Cognome", "Tipologia", "Logged", "Token") FROM stdin;
3241234865	Cristi24	$2y$10$pOPUhyJR10QZtMqeLXXSoe4UB0AMxwh3HpQataUa5xjSaQAjxTkpG	tolve@gmail.it	Cristina	Tolve	f	f	\N
3241254865	Roby21	$2y$10$pOPUhyJR10QZtMqeLXXSoe4UB0AMxwh3HpQataUa5xjSaQAjxTkpG	berta@gmail.it	Roberta	Torna	f	f	\N
3213234539	Strix89	$2y$10$YVZ/aGof.J1fKCDAvdOM5uuJHGUBIQksCqOLIaVJLFFJMGh5Y40sq	boh@libero.it	Mario	Rossi	t	f	\N
3221254865	Fabioly18	$2y$10$pOPUhyJR10QZtMqeLXXSoe4UB0AMxwh3HpQataUa5xjSaQAjxTkpG	ban@gmail.it	Fabiana	Scano	f	f	\N
3241234765	FrancMucc	$2y$10$pOPUhyJR10QZtMqeLXXSoe4UB0AMxwh3HpQataUa5xjSaQAjxTkpG	muccilli@celiaco.it	Francesco	Muccilli	f	f	\N
2121321223	ZioPiero2	$2y$10$jLMtol.NUz40F/L3rb2aU.4/r/ue5V6s.KRnlTugSWBxbFBwhb6gO	ziopiero8899@gmail.com	Ghelia	Valencia	f	f	\N
3213234532	TestUser	$2y$10$pOPUhyJR10QZtMqeLXXSoe4UB0AMxwh3HpQataUa5xjSaQAjxTkpG	fakemail@gmail.com	Guido	LaVespa	t	f	\N
3333232132	ZioPiero	$2y$10$ImiWmwVfDbFqRQptBRz1QOsJcWSfcG1L0i.YWCfbi2eqO1I7VGoi6	fakemail2@gmail.com	Tommy	Orleans	f	f	\N
\.


--
-- Data for Name: VISIT; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public."VISIT" (id, ip_address, "timestamp") FROM stdin;
2	0.0.0.1	2023-06-23 17:41:31
3	0.0.0.1	2023-06-23 17:41:49
4	0.0.0.1	2023-06-23 18:37:27
5	0.0.0.1	2023-06-23 18:37:59
6	0.0.0.1	2023-06-23 18:38:32
7	0.0.0.1	2023-06-23 18:41:12
8	0.0.0.1	2023-06-23 18:41:32
9	0.0.0.1	2023-06-23 18:49:54
10	0.0.0.1	2023-06-23 18:50:11
11	0.0.0.1	2023-06-23 18:50:19
12	0.0.0.1	2023-06-23 18:51:07
13	0.0.0.1	2023-06-23 19:19:18
14	0.0.0.1	2023-06-24 17:08:30
15	150.218.246.27	2023-06-24 20:16:21
16	0.0.0.1	2023-06-24 20:25:34
17	0.0.0.1	2023-06-25 10:04:47
18	0.0.0.1	2023-06-25 10:50:19
19	0.0.0.1	2023-06-25 14:49:50
20	0.0.0.1	2023-06-25 15:54:40
21	0.0.0.1	2023-06-25 18:58:53
22	0.0.0.1	2023-06-25 19:14:32
23	0.0.0.1	2023-06-26 13:45:37
24	0.0.0.1	2023-06-26 13:47:43
25	0.0.0.1	2023-06-28 10:17:11
26	0.0.0.1	2023-06-28 16:02:45
27	0.0.0.1	2023-06-30 14:42:37
28	0.0.0.1	2023-06-30 14:45:48
29	0.0.0.1	2023-07-01 13:59:46
30	0.0.0.1	2023-07-01 14:01:29
31	0.0.0.1	2023-07-02 01:09:12
32	0.0.0.1	2023-07-02 01:10:05
33	0.0.0.1	2023-07-02 15:33:47
34	0.0.0.1	2023-07-02 16:49:38
35	0.0.0.1	2023-07-02 17:24:20
36	0.0.0.1	2023-07-02 17:24:27
37	10.10.11.247	2023-07-05 15:25:15
38	0.0.0.1	2023-07-05 15:26:12
39	10.10.11.253	2023-07-05 15:52:24
40	10.10.11.253	2023-07-05 15:53:06
\.


--
-- Name: LAVORO_ID_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public."LAVORO_ID_seq"', 16, true);


--
-- Name: PRODOTTO_ID_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public."PRODOTTO_ID_seq"', 38, true);


--
-- Name: TRATTAMENTO_ID_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public."TRATTAMENTO_ID_seq"', 29, true);


--
-- Name: VISIT_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public."VISIT_id_seq"', 40, true);


--
-- Name: ANNUNCIO ANNUNCIO_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."ANNUNCIO"
    ADD CONSTRAINT "ANNUNCIO_pkey" PRIMARY KEY ("Data", "Ora", "Telefono");


--
-- Name: IMMAGINE_L IMMAGINE_L_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."IMMAGINE_L"
    ADD CONSTRAINT "IMMAGINE_L_pkey" PRIMARY KEY ("ID_L", "Nome");


--
-- Name: IMMAGINE_P IMMAGINE_P_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."IMMAGINE_P"
    ADD CONSTRAINT "IMMAGINE_P_pkey" PRIMARY KEY ("ID_P", "Nome");


--
-- Name: LAVORO LAVORO_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."LAVORO"
    ADD CONSTRAINT "LAVORO_pkey" PRIMARY KEY ("ID");


--
-- Name: PRENOTAZIONE PRENOTAZIONI_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."PRENOTAZIONE"
    ADD CONSTRAINT "PRENOTAZIONI_pkey" PRIMARY KEY ("Telefono_C", "Data_P", "Ora_P");


--
-- Name: PRODOTTO PRODOTTO_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."PRODOTTO"
    ADD CONSTRAINT "PRODOTTO_pkey" PRIMARY KEY ("ID");


--
-- Name: RECENSIONE RECENSIONE_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."RECENSIONE"
    ADD CONSTRAINT "RECENSIONE_pkey" PRIMARY KEY ("Telefono", "Data_P", "Ora_P", "Data", "Ora");


--
-- Name: TRATTAMENTO TRATTAMENTO_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."TRATTAMENTO"
    ADD CONSTRAINT "TRATTAMENTO_pkey" PRIMARY KEY ("ID");


--
-- Name: UTENTE UTENTE_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."UTENTE"
    ADD CONSTRAINT "UTENTE_pkey" PRIMARY KEY ("Telefono");


--
-- Name: VISIT VISIT_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."VISIT"
    ADD CONSTRAINT "VISIT_pkey" PRIMARY KEY (id);


--
-- Name: PRENOTAZIONE_TRATTAMENTO prenotazione_trattamento_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."PRENOTAZIONE_TRATTAMENTO"
    ADD CONSTRAINT prenotazione_trattamento_pkey PRIMARY KEY ("Telefono_C", "Data_P", "Ora_P", "ID_T");


--
-- Name: UTENTE unique_email; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."UTENTE"
    ADD CONSTRAINT unique_email UNIQUE ("Email");


--
-- Name: UTENTE unique_username; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."UTENTE"
    ADD CONSTRAINT unique_username UNIQUE ("Username");


--
-- Name: ANNUNCIO ANNUNCIO_Telefono_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."ANNUNCIO"
    ADD CONSTRAINT "ANNUNCIO_Telefono_fkey" FOREIGN KEY ("Telefono") REFERENCES public."UTENTE"("Telefono") ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: IMMAGINE_L IMMAGINE_L_ID_L_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."IMMAGINE_L"
    ADD CONSTRAINT "IMMAGINE_L_ID_L_fkey" FOREIGN KEY ("ID_L") REFERENCES public."LAVORO"("ID") ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: IMMAGINE_P IMMAGINE_P_ID_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."IMMAGINE_P"
    ADD CONSTRAINT "IMMAGINE_P_ID_fkey" FOREIGN KEY ("ID_P") REFERENCES public."PRODOTTO"("ID") ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: LAVORO LAVORO_Telefono_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."LAVORO"
    ADD CONSTRAINT "LAVORO_Telefono_fkey" FOREIGN KEY ("Telefono") REFERENCES public."UTENTE"("Telefono") ON UPDATE CASCADE ON DELETE SET NULL;


--
-- Name: PRENOTAZIONE PRENOTAZIONE_Telefono_C_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."PRENOTAZIONE"
    ADD CONSTRAINT "PRENOTAZIONE_Telefono_C_fkey" FOREIGN KEY ("Telefono_C") REFERENCES public."UTENTE"("Telefono") ON UPDATE CASCADE ON DELETE SET NULL;


--
-- Name: PRENOTAZIONE PRENOTAZIONE_Telefono_P_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."PRENOTAZIONE"
    ADD CONSTRAINT "PRENOTAZIONE_Telefono_P_fkey" FOREIGN KEY ("Telefono_P") REFERENCES public."UTENTE"("Telefono") ON UPDATE CASCADE ON DELETE SET NULL;


--
-- Name: PRODOTTO PRODOTTO_Telefono_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."PRODOTTO"
    ADD CONSTRAINT "PRODOTTO_Telefono_fkey" FOREIGN KEY ("Telefono") REFERENCES public."UTENTE"("Telefono") ON UPDATE CASCADE ON DELETE SET NULL;


--
-- Name: RECENSIONE RECENSIONE_PRENOTAZIONE_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."RECENSIONE"
    ADD CONSTRAINT "RECENSIONE_PRENOTAZIONE_fkey" FOREIGN KEY ("Data_P", "Telefono", "Ora_P") REFERENCES public."PRENOTAZIONE"("Data_P", "Telefono_C", "Ora_P") ON UPDATE CASCADE ON DELETE SET NULL;


--
-- Name: TRATTAMENTO TRATTAMENTO_Telefono_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."TRATTAMENTO"
    ADD CONSTRAINT "TRATTAMENTO_Telefono_fkey" FOREIGN KEY ("Telefono") REFERENCES public."UTENTE"("Telefono") ON UPDATE CASCADE ON DELETE SET NULL;


--
-- Name: PRENOTAZIONE_TRATTAMENTO fk_prenotazione_trattamento_prenotazione; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."PRENOTAZIONE_TRATTAMENTO"
    ADD CONSTRAINT fk_prenotazione_trattamento_prenotazione FOREIGN KEY ("Telefono_C", "Data_P", "Ora_P") REFERENCES public."PRENOTAZIONE"("Telefono_C", "Data_P", "Ora_P") ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: PRENOTAZIONE_TRATTAMENTO prenotazione_trattamento_id_t_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."PRENOTAZIONE_TRATTAMENTO"
    ADD CONSTRAINT prenotazione_trattamento_id_t_fkey FOREIGN KEY ("ID_T") REFERENCES public."TRATTAMENTO"("ID");


--
-- PostgreSQL database dump complete
--

