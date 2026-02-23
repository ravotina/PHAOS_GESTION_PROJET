--
-- PostgreSQL database dump
--

-- Dumped from database version 15.3
-- Dumped by pg_dump version 15.3

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
-- Name: a_faire; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.a_faire (
    id integer NOT NULL,
    nom character varying(50) NOT NULL,
    description text,
    id_type_projet integer NOT NULL
);


ALTER TABLE public.a_faire OWNER TO postgres;

--
-- Name: a_faire_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.a_faire_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.a_faire_id_seq OWNER TO postgres;

--
-- Name: a_faire_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.a_faire_id_seq OWNED BY public.a_faire.id;


--
-- Name: calandrier_preparation; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.calandrier_preparation (
    id integer NOT NULL,
    title character varying(250) NOT NULL,
    date_debut timestamp without time zone NOT NULL,
    date_fin timestamp without time zone,
    decription text,
    color character varying(50),
    utilisateur_id integer NOT NULL,
    id_projet integer NOT NULL
);


ALTER TABLE public.calandrier_preparation OWNER TO postgres;

--
-- Name: calandrier_preparation_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.calandrier_preparation_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.calandrier_preparation_id_seq OWNER TO postgres;

--
-- Name: calandrier_preparation_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.calandrier_preparation_id_seq OWNED BY public.calandrier_preparation.id;


--
-- Name: categorie; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.categorie (
    id integer NOT NULL,
    nom character varying(250) NOT NULL,
    description text
);


ALTER TABLE public.categorie OWNER TO postgres;

--
-- Name: categorie_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.categorie_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.categorie_id_seq OWNER TO postgres;

--
-- Name: categorie_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.categorie_id_seq OWNED BY public.categorie.id;


--
-- Name: detaille_a_faire; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.detaille_a_faire (
    id integer NOT NULL,
    nom character varying(250),
    description text,
    fichier character varying(250),
    url character varying(500),
    id_preparation integer NOT NULL
);


ALTER TABLE public.detaille_a_faire OWNER TO postgres;

--
-- Name: detaille_a_faire_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.detaille_a_faire_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.detaille_a_faire_id_seq OWNER TO postgres;

--
-- Name: detaille_a_faire_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.detaille_a_faire_id_seq OWNED BY public.detaille_a_faire.id;


--
-- Name: emploi_du_temps; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.emploi_du_temps (
    id integer NOT NULL,
    date_debut date,
    date_fin date,
    description text,
    id_module_affecter integer NOT NULL,
    id_lancement_du_projet integer NOT NULL
);


ALTER TABLE public.emploi_du_temps OWNER TO postgres;

--
-- Name: emploi_du_temps_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.emploi_du_temps_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.emploi_du_temps_id_seq OWNER TO postgres;

--
-- Name: emploi_du_temps_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.emploi_du_temps_id_seq OWNED BY public.emploi_du_temps.id;


--
-- Name: etape; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.etape (
    id integer NOT NULL,
    nom character varying(100) NOT NULL
);


ALTER TABLE public.etape OWNER TO postgres;

--
-- Name: etape_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.etape_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.etape_id_seq OWNER TO postgres;

--
-- Name: etape_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.etape_id_seq OWNED BY public.etape.id;


--
-- Name: etape_validation_detaille; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.etape_validation_detaille (
    id integer NOT NULL,
    nom character varying(50) NOT NULL,
    description text,
    file character varying(250),
    id_etapes_validation integer NOT NULL
);


ALTER TABLE public.etape_validation_detaille OWNER TO postgres;

--
-- Name: etape_validation_detaille_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.etape_validation_detaille_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.etape_validation_detaille_id_seq OWNER TO postgres;

--
-- Name: etape_validation_detaille_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.etape_validation_detaille_id_seq OWNED BY public.etape_validation_detaille.id;


--
-- Name: etapes_validation; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.etapes_validation (
    id integer NOT NULL,
    type_etape character varying(100) NOT NULL,
    commentaire text,
    date_decision date,
    date_creation date,
    status character varying(50) NOT NULL,
    etape character varying(50) NOT NULL,
    id_workflow_validation integer NOT NULL,
    id_utilisateur integer NOT NULL,
    id_projects_travailler integer NOT NULL,
    id_etape integer NOT NULL
);


ALTER TABLE public.etapes_validation OWNER TO postgres;

--
-- Name: etapes_validation_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.etapes_validation_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.etapes_validation_id_seq OWNER TO postgres;

--
-- Name: etapes_validation_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.etapes_validation_id_seq OWNED BY public.etapes_validation.id;


--
-- Name: lancement_du_projet; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.lancement_du_projet (
    id integer NOT NULL,
    nom character varying(250),
    description text,
    date_debu date,
    date_fin date,
    budget numeric(15,2),
    id_projet_demare integer NOT NULL,
    id_utilisateur integer NOT NULL
);


ALTER TABLE public.lancement_du_projet OWNER TO postgres;

--
-- Name: lancement_du_projet_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.lancement_du_projet_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.lancement_du_projet_id_seq OWNER TO postgres;

--
-- Name: lancement_du_projet_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.lancement_du_projet_id_seq OWNED BY public.lancement_du_projet.id;


--
-- Name: lancement_projet_detaille; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.lancement_projet_detaille (
    id integer NOT NULL,
    nom character varying(50) NOT NULL,
    description text,
    file character varying(250),
    id_lancement_projet integer NOT NULL
);


ALTER TABLE public.lancement_projet_detaille OWNER TO postgres;

--
-- Name: lancement_projet_detaille_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.lancement_projet_detaille_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.lancement_projet_detaille_id_seq OWNER TO postgres;

--
-- Name: lancement_projet_detaille_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.lancement_projet_detaille_id_seq OWNED BY public.lancement_projet_detaille.id;


--
-- Name: module_affecter; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.module_affecter (
    id integer NOT NULL,
    nom character varying(100) NOT NULL
);


ALTER TABLE public.module_affecter OWNER TO postgres;

--
-- Name: notification; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.notification (
    id integer NOT NULL,
    id_utilisateur integer NOT NULL,
    gmail_utilisateur character varying(500),
    table_source character varying(50),
    date_heur_notification timestamp without time zone,
    titre character varying(50) NOT NULL,
    date_debu date,
    date_fin date,
    description character varying(50),
    etat integer,
    id_table_source integer
);


ALTER TABLE public.notification OWNER TO postgres;

--
-- Name: notification_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.notification_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.notification_id_seq OWNER TO postgres;

--
-- Name: notification_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.notification_id_seq OWNED BY public.notification.id;


--
-- Name: preparation; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.preparation (
    id integer NOT NULL,
    description text NOT NULL,
    daty date,
    id_utilisateur_concerner integer NOT NULL,
    id_utilisateur integer NOT NULL,
    id_a_faire integer NOT NULL
);


ALTER TABLE public.preparation OWNER TO postgres;

--
-- Name: preparation_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.preparation_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.preparation_id_seq OWNER TO postgres;

--
-- Name: preparation_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.preparation_id_seq OWNED BY public.preparation.id;


--
-- Name: projects_travailler; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.projects_travailler (
    id integer NOT NULL,
    numero_projet character varying(50) NOT NULL,
    titre character varying(50) NOT NULL,
    description text,
    objectif text,
    date_debu date,
    date_fin date,
    id_lancement_projet integer NOT NULL,
    id_utilisateur integer NOT NULL,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.projects_travailler OWNER TO postgres;

--
-- Name: projects_travailler_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.projects_travailler_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.projects_travailler_id_seq OWNER TO postgres;

--
-- Name: projects_travailler_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.projects_travailler_id_seq OWNED BY public.projects_travailler.id;


--
-- Name: projet; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.projet (
    id integer NOT NULL,
    non_de_projet character varying(250) NOT NULL,
    date_debu date,
    date_fin date,
    dedlinne integer,
    description text,
    id_utilisateur integer NOT NULL,
    id_client character varying(50) NOT NULL,
    id_categorie integer NOT NULL,
    id_type_intervention integer NOT NULL,
    id_type_projet integer NOT NULL,
    status character varying(20) DEFAULT 'brouillon'::character varying NOT NULL,
    actif boolean DEFAULT false
);


ALTER TABLE public.projet OWNER TO postgres;

--
-- Name: projet_demare; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.projet_demare (
    id integer NOT NULL,
    non_de_projet character varying(250) NOT NULL,
    date_debu date,
    date_fin date,
    dedlinne integer,
    description text,
    id_utilisateur integer NOT NULL,
    id_client integer NOT NULL,
    id_projet integer NOT NULL,
    status character varying(20) DEFAULT 'brouillon'::character varying,
    CONSTRAINT projet_demare_status_check CHECK (((status)::text = ANY ((ARRAY['brouillon'::character varying, 'en_cours'::character varying, 'termine'::character varying, 'annule'::character varying])::text[])))
);


ALTER TABLE public.projet_demare OWNER TO postgres;

--
-- Name: projet_demare_detaille; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.projet_demare_detaille (
    id integer NOT NULL,
    nom character varying(50) NOT NULL,
    description text,
    file character varying(250),
    id_projet_demare integer NOT NULL,
    url character varying(500)
);


ALTER TABLE public.projet_demare_detaille OWNER TO postgres;

--
-- Name: projet_demare_detaille_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.projet_demare_detaille_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.projet_demare_detaille_id_seq OWNER TO postgres;

--
-- Name: projet_demare_detaille_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.projet_demare_detaille_id_seq OWNED BY public.projet_demare_detaille.id;


--
-- Name: projet_demare_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.projet_demare_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.projet_demare_id_seq OWNER TO postgres;

--
-- Name: projet_demare_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.projet_demare_id_seq OWNED BY public.projet_demare.id;


--
-- Name: projet_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.projet_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.projet_id_seq OWNER TO postgres;

--
-- Name: projet_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.projet_id_seq OWNED BY public.projet.id;


--
-- Name: projet_travailler_detaille; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.projet_travailler_detaille (
    id integer NOT NULL,
    nom character varying(50) NOT NULL,
    description text,
    file character varying(250),
    id_projects_travailler integer NOT NULL
);


ALTER TABLE public.projet_travailler_detaille OWNER TO postgres;

--
-- Name: projet_travailler_detaille_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.projet_travailler_detaille_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.projet_travailler_detaille_id_seq OWNER TO postgres;

--
-- Name: projet_travailler_detaille_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.projet_travailler_detaille_id_seq OWNED BY public.projet_travailler_detaille.id;


--
-- Name: token_user; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.token_user (
    id integer NOT NULL,
    id_user integer NOT NULL,
    token character varying(300) NOT NULL
);


ALTER TABLE public.token_user OWNER TO postgres;

--
-- Name: token_user_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.token_user_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.token_user_id_seq OWNER TO postgres;

--
-- Name: token_user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.token_user_id_seq OWNED BY public.token_user.id;


--
-- Name: type_intervention; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.type_intervention (
    id integer NOT NULL,
    nom character varying(250) NOT NULL,
    description text
);


ALTER TABLE public.type_intervention OWNER TO postgres;

--
-- Name: type_intervention_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.type_intervention_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.type_intervention_id_seq OWNER TO postgres;

--
-- Name: type_intervention_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.type_intervention_id_seq OWNED BY public.type_intervention.id;


--
-- Name: type_projet; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.type_projet (
    id integer NOT NULL,
    nom character varying(250) NOT NULL,
    description text
);


ALTER TABLE public.type_projet OWNER TO postgres;

--
-- Name: type_projet_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.type_projet_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.type_projet_id_seq OWNER TO postgres;

--
-- Name: type_projet_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.type_projet_id_seq OWNED BY public.type_projet.id;


--
-- Name: utilisateur_concerner; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.utilisateur_concerner (
    id integer NOT NULL,
    description_tache text,
    id_utilsateur integer NOT NULL,
    id_calandrier integer NOT NULL
);


ALTER TABLE public.utilisateur_concerner OWNER TO postgres;

--
-- Name: utilisateur_concerner_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.utilisateur_concerner_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.utilisateur_concerner_id_seq OWNER TO postgres;

--
-- Name: utilisateur_concerner_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.utilisateur_concerner_id_seq OWNED BY public.utilisateur_concerner.id;


--
-- Name: utilisateur_concerner_workflow; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.utilisateur_concerner_workflow (
    id integer NOT NULL,
    commentaires text,
    id_utilisateur integer NOT NULL,
    id_workflow_validation integer NOT NULL,
    status_validation integer DEFAULT 0,
    date_validation timestamp without time zone,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.utilisateur_concerner_workflow OWNER TO postgres;

--
-- Name: utilisateur_concerner_workflow_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.utilisateur_concerner_workflow_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.utilisateur_concerner_workflow_id_seq OWNER TO postgres;

--
-- Name: utilisateur_concerner_workflow_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.utilisateur_concerner_workflow_id_seq OWNED BY public.utilisateur_concerner_workflow.id;


--
-- Name: vue_fichiers_preparations; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.vue_fichiers_preparations AS
 SELECT pd.id AS projet_id,
    pd.non_de_projet,
    cp.title AS titre_calendrier,
    uc.description_tache,
    p.description AS description_preparation,
    p.daty AS date_preparation,
    af.nom AS type_tache,
    daf.id AS detail_id,
    daf.nom AS nom_detail,
    daf.description AS description_detail,
    daf.fichier,
    daf.url,
        CASE
            WHEN (daf.fichier IS NOT NULL) THEN ('uploads/detaille_a_faire/'::text || (daf.fichier)::text)
            ELSE NULL::text
        END AS chemin_fichier,
        CASE
            WHEN ((daf.fichier)::text ~~ '%.pdf'::text) THEN 'PDF'::text
            WHEN ((daf.fichier)::text ~~ '%.doc%'::text) THEN 'Word'::text
            WHEN ((daf.fichier)::text ~~ '%.xls%'::text) THEN 'Excel'::text
            WHEN (((daf.fichier)::text ~~ '%.jpg'::text) OR ((daf.fichier)::text ~~ '%.jpeg'::text)) THEN 'Image JPEG'::text
            WHEN ((daf.fichier)::text ~~ '%.png'::text) THEN 'Image PNG'::text
            WHEN ((daf.fichier)::text ~~ '%.txt'::text) THEN 'Texte'::text
            ELSE 'Autre'::text
        END AS type_fichier,
    "substring"((daf.fichier)::text, '\.([^\.]+)$'::text) AS extension
   FROM (((((public.projet_demare pd
     JOIN public.calandrier_preparation cp ON ((pd.id = cp.id_projet)))
     JOIN public.utilisateur_concerner uc ON ((cp.id = uc.id_calandrier)))
     JOIN public.preparation p ON ((uc.id = p.id_utilisateur_concerner)))
     JOIN public.a_faire af ON ((p.id_a_faire = af.id)))
     JOIN public.detaille_a_faire daf ON ((p.id = daf.id_preparation)))
  WHERE (daf.fichier IS NOT NULL)
  ORDER BY pd.id, cp.date_debut, p.daty DESC, daf.id;


ALTER TABLE public.vue_fichiers_preparations OWNER TO postgres;

--
-- Name: vue_preparations_projet; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.vue_preparations_projet AS
 SELECT pd.id AS projet_id,
    pd.non_de_projet,
    pd.status AS statut_projet,
    cp.id AS calendrier_id,
    cp.title AS titre_calendrier,
    cp.date_debut AS date_debut_calendrier,
    cp.date_fin AS date_fin_calendrier,
    cp.color AS couleur_calendrier,
    uc.id AS utilisateur_concerner_id,
    uc.description_tache,
    uc.id_utilsateur AS id_utilisateur_assignee,
    p.id AS preparation_id,
    p.description AS description_preparation,
    p.daty AS date_preparation,
    p.id_utilisateur AS id_createur_preparation,
    af.id AS a_faire_id,
    af.nom AS type_tache,
    count(daf.id) AS nombre_details,
    string_agg((daf.nom)::text, ', '::text) AS noms_details
   FROM (((((public.projet_demare pd
     LEFT JOIN public.calandrier_preparation cp ON ((pd.id = cp.id_projet)))
     LEFT JOIN public.utilisateur_concerner uc ON ((cp.id = uc.id_calandrier)))
     LEFT JOIN public.preparation p ON ((uc.id = p.id_utilisateur_concerner)))
     LEFT JOIN public.a_faire af ON ((p.id_a_faire = af.id)))
     LEFT JOIN public.detaille_a_faire daf ON ((p.id = daf.id_preparation)))
  GROUP BY pd.id, pd.non_de_projet, pd.status, cp.id, cp.title, cp.date_debut, cp.date_fin, cp.color, uc.id, uc.description_tache, uc.id_utilsateur, p.id, p.description, p.daty, p.id_utilisateur, af.id, af.nom
  ORDER BY pd.id, cp.date_debut, uc.id, p.daty DESC;


ALTER TABLE public.vue_preparations_projet OWNER TO postgres;

--
-- Name: vue_preparations_projet_complete; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.vue_preparations_projet_complete AS
 SELECT pd.id AS projet_id,
    pd.non_de_projet,
    pd.status AS statut_projet,
    pd.description AS description_projet,
    pd.date_debu AS date_debut_projet,
    pd.date_fin AS date_fin_projet,
    cp.id AS calendrier_id,
    cp.title AS titre_calendrier,
    cp.date_debut AS date_debut_calendrier,
    cp.date_fin AS date_fin_calendrier,
    cp.decription AS description_calendrier,
    cp.color AS couleur_calendrier,
    cp.utilisateur_id AS createur_calendrier,
    uc.id AS utilisateur_concerner_id,
    uc.description_tache,
    uc.id_utilsateur AS id_utilisateur_assignee,
    p.id AS preparation_id,
    p.description AS description_preparation,
    p.daty AS date_preparation,
    p.id_utilisateur AS id_createur_preparation,
    af.id AS a_faire_id,
    af.nom AS type_tache,
    count(DISTINCT daf.id) AS nombre_details,
    json_agg(json_build_object('detail_id', daf.id, 'nom', daf.nom, 'description', daf.description, 'fichier', daf.fichier, 'url', daf.url, 'has_file',
        CASE
            WHEN (daf.fichier IS NOT NULL) THEN true
            ELSE false
        END, 'file_type',
        CASE
            WHEN ((daf.fichier)::text ~~ '%.pdf'::text) THEN 'PDF'::text
            WHEN ((daf.fichier)::text ~~ '%.doc%'::text) THEN 'Word'::text
            WHEN ((daf.fichier)::text ~~ '%.xls%'::text) THEN 'Excel'::text
            WHEN (((daf.fichier)::text ~~ '%.jpg'::text) OR ((daf.fichier)::text ~~ '%.jpeg'::text) OR ((daf.fichier)::text ~~ '%.png'::text)) THEN 'Image'::text
            WHEN ((daf.fichier)::text ~~ '%.txt'::text) THEN 'Texte'::text
            ELSE 'Autre'::text
        END) ORDER BY daf.id) FILTER (WHERE (daf.id IS NOT NULL)) AS details_json
   FROM (((((public.projet_demare pd
     LEFT JOIN public.calandrier_preparation cp ON ((pd.id = cp.id_projet)))
     LEFT JOIN public.utilisateur_concerner uc ON ((cp.id = uc.id_calandrier)))
     LEFT JOIN public.preparation p ON ((uc.id = p.id_utilisateur_concerner)))
     LEFT JOIN public.a_faire af ON ((p.id_a_faire = af.id)))
     LEFT JOIN public.detaille_a_faire daf ON ((p.id = daf.id_preparation)))
  GROUP BY pd.id, pd.non_de_projet, pd.status, pd.description, pd.date_debu, pd.date_fin, cp.id, cp.title, cp.date_debut, cp.date_fin, cp.decription, cp.color, cp.utilisateur_id, uc.id, uc.description_tache, uc.id_utilsateur, p.id, p.description, p.daty, p.id_utilisateur, af.id, af.nom
  ORDER BY pd.id, cp.date_debut, uc.id, p.daty DESC;


ALTER TABLE public.vue_preparations_projet_complete OWNER TO postgres;

--
-- Name: workflow_validation; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.workflow_validation (
    id integer NOT NULL,
    nom_etape character varying(50) NOT NULL,
    date_arriver timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    date_fin_de_validation timestamp without time zone,
    commentaires text,
    status integer DEFAULT 0,
    id_parent integer,
    id_projects_travailler integer NOT NULL,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.workflow_validation OWNER TO postgres;

--
-- Name: workflow_validation_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.workflow_validation_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.workflow_validation_id_seq OWNER TO postgres;

--
-- Name: workflow_validation_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.workflow_validation_id_seq OWNED BY public.workflow_validation.id;


--
-- Name: a_faire id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.a_faire ALTER COLUMN id SET DEFAULT nextval('public.a_faire_id_seq'::regclass);


--
-- Name: calandrier_preparation id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.calandrier_preparation ALTER COLUMN id SET DEFAULT nextval('public.calandrier_preparation_id_seq'::regclass);


--
-- Name: categorie id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categorie ALTER COLUMN id SET DEFAULT nextval('public.categorie_id_seq'::regclass);


--
-- Name: detaille_a_faire id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detaille_a_faire ALTER COLUMN id SET DEFAULT nextval('public.detaille_a_faire_id_seq'::regclass);


--
-- Name: emploi_du_temps id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.emploi_du_temps ALTER COLUMN id SET DEFAULT nextval('public.emploi_du_temps_id_seq'::regclass);


--
-- Name: etape id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.etape ALTER COLUMN id SET DEFAULT nextval('public.etape_id_seq'::regclass);


--
-- Name: etape_validation_detaille id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.etape_validation_detaille ALTER COLUMN id SET DEFAULT nextval('public.etape_validation_detaille_id_seq'::regclass);


--
-- Name: etapes_validation id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.etapes_validation ALTER COLUMN id SET DEFAULT nextval('public.etapes_validation_id_seq'::regclass);


--
-- Name: lancement_du_projet id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.lancement_du_projet ALTER COLUMN id SET DEFAULT nextval('public.lancement_du_projet_id_seq'::regclass);


--
-- Name: lancement_projet_detaille id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.lancement_projet_detaille ALTER COLUMN id SET DEFAULT nextval('public.lancement_projet_detaille_id_seq'::regclass);


--
-- Name: notification id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.notification ALTER COLUMN id SET DEFAULT nextval('public.notification_id_seq'::regclass);


--
-- Name: preparation id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.preparation ALTER COLUMN id SET DEFAULT nextval('public.preparation_id_seq'::regclass);


--
-- Name: projects_travailler id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.projects_travailler ALTER COLUMN id SET DEFAULT nextval('public.projects_travailler_id_seq'::regclass);


--
-- Name: projet id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.projet ALTER COLUMN id SET DEFAULT nextval('public.projet_id_seq'::regclass);


--
-- Name: projet_demare id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.projet_demare ALTER COLUMN id SET DEFAULT nextval('public.projet_demare_id_seq'::regclass);


--
-- Name: projet_demare_detaille id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.projet_demare_detaille ALTER COLUMN id SET DEFAULT nextval('public.projet_demare_detaille_id_seq'::regclass);


--
-- Name: projet_travailler_detaille id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.projet_travailler_detaille ALTER COLUMN id SET DEFAULT nextval('public.projet_travailler_detaille_id_seq'::regclass);


--
-- Name: token_user id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.token_user ALTER COLUMN id SET DEFAULT nextval('public.token_user_id_seq'::regclass);


--
-- Name: type_intervention id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.type_intervention ALTER COLUMN id SET DEFAULT nextval('public.type_intervention_id_seq'::regclass);


--
-- Name: type_projet id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.type_projet ALTER COLUMN id SET DEFAULT nextval('public.type_projet_id_seq'::regclass);


--
-- Name: utilisateur_concerner id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.utilisateur_concerner ALTER COLUMN id SET DEFAULT nextval('public.utilisateur_concerner_id_seq'::regclass);


--
-- Name: utilisateur_concerner_workflow id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.utilisateur_concerner_workflow ALTER COLUMN id SET DEFAULT nextval('public.utilisateur_concerner_workflow_id_seq'::regclass);


--
-- Name: workflow_validation id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.workflow_validation ALTER COLUMN id SET DEFAULT nextval('public.workflow_validation_id_seq'::regclass);


--
-- Data for Name: a_faire; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.a_faire (id, nom, description, id_type_projet) FROM stdin;
1	Approche	bla bla bla m	2
5	calandrier	calandrier de la mission	2
\.


--
-- Data for Name: calandrier_preparation; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.calandrier_preparation (id, title, date_debut, date_fin, decription, color, utilisateur_id, id_projet) FROM stdin;
55	nettoyage des données t	2026-01-30 10:55:00	2026-01-31 10:55:00	nettoyage	#979929	1	9
63	test	2026-01-01 09:49:00	2026-01-23 09:49:00	test	#3788d8	1	9
59	Traitement des donner	2026-01-28 08:55:00	2026-01-31 08:55:00	description traitement des donner	#3788d8	1	9
\.


--
-- Data for Name: categorie; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.categorie (id, nom, description) FROM stdin;
4	A distance	Projet realise entierement a distance
5	Sur terrain	Projet necessitant des deplacements sur site
6	Hybride	Combinaison de travail a distance et sur terrain
\.


--
-- Data for Name: detaille_a_faire; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.detaille_a_faire (id, nom, description, fichier, url, id_preparation) FROM stdin;
\.


--
-- Data for Name: emploi_du_temps; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.emploi_du_temps (id, date_debut, date_fin, description, id_module_affecter, id_lancement_du_projet) FROM stdin;
\.


--
-- Data for Name: etape; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.etape (id, nom) FROM stdin;
1	Validation initiale
2	RÃ©vision technique
3	Approbation manager
4	Consultation juridique
5	Validation finale
6	ContrÃ´le qualitÃ©
7	Signature direction
8	Archivage
12	premier etape proJ67
13	triage
14	traitement donner
\.


--
-- Data for Name: etape_validation_detaille; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.etape_validation_detaille (id, nom, description, file, id_etapes_validation) FROM stdin;
\.


--
-- Data for Name: etapes_validation; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.etapes_validation (id, type_etape, commentaire, date_decision, date_creation, status, etape, id_workflow_validation, id_utilisateur, id_projects_travailler, id_etape) FROM stdin;
\.


--
-- Data for Name: lancement_du_projet; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.lancement_du_projet (id, nom, description, date_debu, date_fin, budget, id_projet_demare, id_utilisateur) FROM stdin;
\.


--
-- Data for Name: lancement_projet_detaille; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.lancement_projet_detaille (id, nom, description, file, id_lancement_projet) FROM stdin;
\.


--
-- Data for Name: module_affecter; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.module_affecter (id, nom) FROM stdin;
1	Mission
2	Achat
3	Projet
4	Finance
\.


--
-- Data for Name: notification; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.notification (id, id_utilisateur, gmail_utilisateur, table_source, date_heur_notification, titre, date_debu, date_fin, description, etat, id_table_source) FROM stdin;
\.


--
-- Data for Name: preparation; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.preparation (id, description, daty, id_utilisateur_concerner, id_utilisateur, id_a_faire) FROM stdin;
\.


--
-- Data for Name: projects_travailler; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.projects_travailler (id, numero_projet, titre, description, objectif, date_debu, date_fin, id_lancement_projet, id_utilisateur, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: projet; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.projet (id, non_de_projet, date_debu, date_fin, dedlinne, description, id_utilisateur, id_client, id_categorie, id_type_intervention, id_type_projet, status, actif) FROM stdin;
5	FIMMO	2026-01-19	2026-01-30	\N	REALISATION ETUDE SOLAIRE ROOFTOP	13	5	4	1	6	brouillon	f
7	Plateforme Gestion de Projet	2026-01-23	2026-03-31	\N	pour faciliter la gestion de Projet Phaos .......	11	8	6	2	8	brouillon	f
8	ANKA Lot 3	2026-01-10	2026-03-15	\N	description Lot 3	14	6	5	1	7	brouillon	f
9	projet 1	2026-01-23	2026-02-05	\N	phaos academy BtoB	11	8	6	2	9	brouillon	t
\.


--
-- Data for Name: projet_demare; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.projet_demare (id, non_de_projet, date_debu, date_fin, dedlinne, description, id_utilisateur, id_client, id_projet, status) FROM stdin;
1	Audit Energetique Siege Social PHAOS	2024-01-15	2024-02-28	45	Audit energetique complet du siege social : analyse consommation electrique, isolation, systeme de chauffage et climatisation. Preconisations d economies d energie.	1	1	1	brouillon
2	Audit Industriel Usine TANA METAL	2024-02-01	2024-04-15	75	Audit energetique approfondi de l usine industrielle : optimisation des moteurs electriques, recuperation de chaleur, analyse des contrats d energie.	1	2	2	brouillon
3	Prospection Hotels Touristique	2024-01-10	2024-03-31	80	Prospection pour audits energetiques dans le secteur hotelier : identification des etablissements a fort potentiel d economies (climatisation, eau chaude, eclairage).	2	3	3	brouillon
4	Audit Batiment Public Mairie IVATO	2024-02-20	2024-05-30	100	Audit energetique reglementaire pour batiment public : conformite normes, optimisation energetique, etude de faisabilite panneaux solaires.	2	4	2	brouillon
5	Audit Reseau Eclairage Public	2024-03-01	2024-06-15	105	Audit du reseau d eclairage public communal : diagnostic des luminaires, proposition de passage aux LED, etude de financement.	1	5	2	brouillon
6	non projet test	2025-11-05	2025-12-02	30	sdfghj dfghjk	7	3	2	brouillon
7	metrogride Ambatofinandrahana	2024-01-12	2026-09-09	60	metrogide projet aghjk dfghjk dfghj	1	1	2	brouillon
8	metrogride Ambatofinan	2025-11-27	2026-01-28	\N	\N	6	3	2	brouillon
9	metrogride Ambatofinandrahana reacte	2025-12-05	2025-12-13	\N	fghjkl sdfghjkl drtyuio ertyio	7	3	2	brouillon
10	electrification !anka	2026-01-09	2026-10-29	100	vbn,	1	2	2	brouillon
\.


--
-- Data for Name: projet_demare_detaille; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.projet_demare_detaille (id, nom, description, file, id_projet_demare, url) FROM stdin;
11	un fichier	un fichier_fimo	projet_details/1769156457_GE.xlsx	5	\N
\.


--
-- Data for Name: projet_travailler_detaille; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.projet_travailler_detaille (id, nom, description, file, id_projects_travailler) FROM stdin;
\.


--
-- Data for Name: token_user; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.token_user (id, id_user, token) FROM stdin;
1	1	ZZSb1GONt5aowR31z1547Qh9ScR7sGhu
3	11	6p3l6GFnBzF2QpWOqlxhT580r70lGD7K
4	13	d4tR5i2FwSfVWi6KGbw332brL70lR1SR
5	14	pZ7d823jvj2UWn1ZRSKFUv492nnoQ4nG
\.


--
-- Data for Name: type_intervention; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.type_intervention (id, nom, description) FROM stdin;
1	Projet Client	Projet realise pour un client externe
2	Projet Interne	Projet realise pour les besoins internes de l'entreprise
3	Partenaire	Projet realise en partenariat avec d'autres entreprises
\.


--
-- Data for Name: type_projet; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.type_projet (id, nom, description) FROM stdin;
6	Conseil et ingenierie	Conseil & Ingenierie (DCI) : Etudes techniques - Faisabilite - dimensionnement - Planification strategique - Business plans
7	Audit, inspection & Controle	Audit- Inspection & Controle (DAIC) : Audits energetiques- Conformite aux normes (ISO/IEC) - Inspections techniques- Due diligence
8	Digital et solutions techniques	Digital & Solutions Techniques (DDST) : Smart energy- Digitalisation- Supervision et monitoring- Comptage intelligent ; Solutions de prepaiement
9	Formation et renforcement des capacites	Formation & Renforcement de Capacites (DFRC) : Formations certifiantes- Transfert de competences- Montee en expertise locale
10	Placement & Externalisation RH	Placement & Externalisation RH (DPE) : Mise a disposition de techniciens et ingenieurs qualifies- Portage salarial - Recrutement sur mesure
\.


--
-- Data for Name: utilisateur_concerner; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.utilisateur_concerner (id, description_tache, id_utilsateur, id_calandrier) FROM stdin;
14	description de son tache	11	63
15	description test	13	63
16	Triage Donner Anka Lot 3	11	59
\.


--
-- Data for Name: utilisateur_concerner_workflow; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.utilisateur_concerner_workflow (id, commentaires, id_utilisateur, id_workflow_validation, status_validation, date_validation, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: workflow_validation; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.workflow_validation (id, nom_etape, date_arriver, date_fin_de_validation, commentaires, status, id_parent, id_projects_travailler, created_at, updated_at) FROM stdin;
\.


--
-- Name: a_faire_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.a_faire_id_seq', 5, true);


--
-- Name: calandrier_preparation_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.calandrier_preparation_id_seq', 63, true);


--
-- Name: categorie_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.categorie_id_seq', 9, true);


--
-- Name: detaille_a_faire_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.detaille_a_faire_id_seq', 6, true);


--
-- Name: emploi_du_temps_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.emploi_du_temps_id_seq', 10, true);


--
-- Name: etape_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.etape_id_seq', 14, true);


--
-- Name: etape_validation_detaille_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.etape_validation_detaille_id_seq', 7, true);


--
-- Name: etapes_validation_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.etapes_validation_id_seq', 7, true);


--
-- Name: lancement_du_projet_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.lancement_du_projet_id_seq', 2, true);


--
-- Name: lancement_projet_detaille_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.lancement_projet_detaille_id_seq', 2, true);


--
-- Name: notification_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.notification_id_seq', 60, true);


--
-- Name: preparation_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.preparation_id_seq', 5, true);


--
-- Name: projects_travailler_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.projects_travailler_id_seq', 15, true);


--
-- Name: projet_demare_detaille_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.projet_demare_detaille_id_seq', 11, true);


--
-- Name: projet_demare_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.projet_demare_id_seq', 10, true);


--
-- Name: projet_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.projet_id_seq', 9, true);


--
-- Name: projet_travailler_detaille_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.projet_travailler_detaille_id_seq', 8, true);


--
-- Name: token_user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.token_user_id_seq', 5, true);


--
-- Name: type_intervention_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.type_intervention_id_seq', 7, true);


--
-- Name: type_projet_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.type_projet_id_seq', 21, true);


--
-- Name: utilisateur_concerner_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.utilisateur_concerner_id_seq', 16, true);


--
-- Name: utilisateur_concerner_workflow_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.utilisateur_concerner_workflow_id_seq', 9, true);


--
-- Name: workflow_validation_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.workflow_validation_id_seq', 17, true);


--
-- Name: a_faire a_faire_nom_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.a_faire
    ADD CONSTRAINT a_faire_nom_key UNIQUE (nom);


--
-- Name: a_faire a_faire_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.a_faire
    ADD CONSTRAINT a_faire_pkey PRIMARY KEY (id);


--
-- Name: calandrier_preparation calandrier_preparation_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.calandrier_preparation
    ADD CONSTRAINT calandrier_preparation_pkey PRIMARY KEY (id);


--
-- Name: categorie categorie_nom_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categorie
    ADD CONSTRAINT categorie_nom_key UNIQUE (nom);


--
-- Name: categorie categorie_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categorie
    ADD CONSTRAINT categorie_pkey PRIMARY KEY (id);


--
-- Name: detaille_a_faire detaille_a_faire_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detaille_a_faire
    ADD CONSTRAINT detaille_a_faire_pkey PRIMARY KEY (id);


--
-- Name: emploi_du_temps emploi_du_temps_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.emploi_du_temps
    ADD CONSTRAINT emploi_du_temps_pkey PRIMARY KEY (id);


--
-- Name: etape etape_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.etape
    ADD CONSTRAINT etape_pkey PRIMARY KEY (id);


--
-- Name: etape_validation_detaille etape_validation_detaille_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.etape_validation_detaille
    ADD CONSTRAINT etape_validation_detaille_pkey PRIMARY KEY (id);


--
-- Name: etapes_validation etapes_validation_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.etapes_validation
    ADD CONSTRAINT etapes_validation_pkey PRIMARY KEY (id);


--
-- Name: lancement_du_projet lancement_du_projet_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.lancement_du_projet
    ADD CONSTRAINT lancement_du_projet_pkey PRIMARY KEY (id);


--
-- Name: lancement_projet_detaille lancement_projet_detaille_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.lancement_projet_detaille
    ADD CONSTRAINT lancement_projet_detaille_pkey PRIMARY KEY (id);


--
-- Name: module_affecter module_affecter_nom_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.module_affecter
    ADD CONSTRAINT module_affecter_nom_key UNIQUE (nom);


--
-- Name: module_affecter module_affecter_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.module_affecter
    ADD CONSTRAINT module_affecter_pkey PRIMARY KEY (id);


--
-- Name: notification notification_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.notification
    ADD CONSTRAINT notification_pkey PRIMARY KEY (id);


--
-- Name: preparation preparation_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.preparation
    ADD CONSTRAINT preparation_pkey PRIMARY KEY (id);


--
-- Name: projects_travailler projects_travailler_numero_projet_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.projects_travailler
    ADD CONSTRAINT projects_travailler_numero_projet_key UNIQUE (numero_projet);


--
-- Name: projects_travailler projects_travailler_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.projects_travailler
    ADD CONSTRAINT projects_travailler_pkey PRIMARY KEY (id);


--
-- Name: projet_demare_detaille projet_demare_detaille_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.projet_demare_detaille
    ADD CONSTRAINT projet_demare_detaille_pkey PRIMARY KEY (id);


--
-- Name: projet_demare projet_demare_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.projet_demare
    ADD CONSTRAINT projet_demare_pkey PRIMARY KEY (id);


--
-- Name: projet projet_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.projet
    ADD CONSTRAINT projet_pkey PRIMARY KEY (id);


--
-- Name: projet_travailler_detaille projet_travailler_detaille_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.projet_travailler_detaille
    ADD CONSTRAINT projet_travailler_detaille_pkey PRIMARY KEY (id);


--
-- Name: token_user token_user_id_user_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.token_user
    ADD CONSTRAINT token_user_id_user_key UNIQUE (id_user);


--
-- Name: token_user token_user_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.token_user
    ADD CONSTRAINT token_user_pkey PRIMARY KEY (id);


--
-- Name: type_intervention type_intervention_nom_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.type_intervention
    ADD CONSTRAINT type_intervention_nom_key UNIQUE (nom);


--
-- Name: type_intervention type_intervention_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.type_intervention
    ADD CONSTRAINT type_intervention_pkey PRIMARY KEY (id);


--
-- Name: type_projet type_projet_nom_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.type_projet
    ADD CONSTRAINT type_projet_nom_key UNIQUE (nom);


--
-- Name: type_projet type_projet_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.type_projet
    ADD CONSTRAINT type_projet_pkey PRIMARY KEY (id);


--
-- Name: utilisateur_concerner utilisateur_concerner_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.utilisateur_concerner
    ADD CONSTRAINT utilisateur_concerner_pkey PRIMARY KEY (id);


--
-- Name: utilisateur_concerner_workflow utilisateur_concerner_workflow_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.utilisateur_concerner_workflow
    ADD CONSTRAINT utilisateur_concerner_workflow_pkey PRIMARY KEY (id);


--
-- Name: workflow_validation workflow_validation_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.workflow_validation
    ADD CONSTRAINT workflow_validation_pkey PRIMARY KEY (id);


--
-- Name: calandrier_preparation calandrier_preparation_offre_projet_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.calandrier_preparation
    ADD CONSTRAINT calandrier_preparation_offre_projet_id_fkey FOREIGN KEY (id_projet) REFERENCES public.projet_demare(id);


--
-- Name: detaille_a_faire detaille_a_faire_id_preparation_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detaille_a_faire
    ADD CONSTRAINT detaille_a_faire_id_preparation_fkey FOREIGN KEY (id_preparation) REFERENCES public.preparation(id);


--
-- Name: emploi_du_temps emploi_du_temps_id_lancement_du_projet_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.emploi_du_temps
    ADD CONSTRAINT emploi_du_temps_id_lancement_du_projet_fkey FOREIGN KEY (id_lancement_du_projet) REFERENCES public.lancement_du_projet(id);


--
-- Name: emploi_du_temps emploi_du_temps_id_module_affecter_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.emploi_du_temps
    ADD CONSTRAINT emploi_du_temps_id_module_affecter_fkey FOREIGN KEY (id_module_affecter) REFERENCES public.module_affecter(id);


--
-- Name: etape_validation_detaille etape_validation_detaille_id_etapes_validation_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.etape_validation_detaille
    ADD CONSTRAINT etape_validation_detaille_id_etapes_validation_fkey FOREIGN KEY (id_etapes_validation) REFERENCES public.etapes_validation(id);


--
-- Name: etapes_validation etapes_validation_id_etape_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.etapes_validation
    ADD CONSTRAINT etapes_validation_id_etape_fkey FOREIGN KEY (id_etape) REFERENCES public.etape(id);


--
-- Name: etapes_validation etapes_validation_id_projects_travailler_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.etapes_validation
    ADD CONSTRAINT etapes_validation_id_projects_travailler_fkey FOREIGN KEY (id_projects_travailler) REFERENCES public.projects_travailler(id);


--
-- Name: etapes_validation etapes_validation_id_workflow_validation_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.etapes_validation
    ADD CONSTRAINT etapes_validation_id_workflow_validation_fkey FOREIGN KEY (id_workflow_validation) REFERENCES public.workflow_validation(id);


--
-- Name: calandrier_preparation fk_calandrier_preparation; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.calandrier_preparation
    ADD CONSTRAINT fk_calandrier_preparation FOREIGN KEY (id_projet) REFERENCES public.projet(id);


--
-- Name: lancement_du_projet lancement_du_projet_id_projet_demare_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.lancement_du_projet
    ADD CONSTRAINT lancement_du_projet_id_projet_demare_fkey FOREIGN KEY (id_projet_demare) REFERENCES public.projet_demare(id);


--
-- Name: lancement_projet_detaille lancement_projet_detaille_id_lancement_projet_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.lancement_projet_detaille
    ADD CONSTRAINT lancement_projet_detaille_id_lancement_projet_fkey FOREIGN KEY (id_lancement_projet) REFERENCES public.lancement_du_projet(id);


--
-- Name: preparation preparation_id_a_faire_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.preparation
    ADD CONSTRAINT preparation_id_a_faire_fkey FOREIGN KEY (id_a_faire) REFERENCES public.a_faire(id);


--
-- Name: preparation preparation_id_utilisateur_concerner_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.preparation
    ADD CONSTRAINT preparation_id_utilisateur_concerner_fkey FOREIGN KEY (id_utilisateur_concerner) REFERENCES public.utilisateur_concerner(id);


--
-- Name: projects_travailler projects_travailler_id_lancement_projet_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.projects_travailler
    ADD CONSTRAINT projects_travailler_id_lancement_projet_fkey FOREIGN KEY (id_lancement_projet) REFERENCES public.lancement_du_projet(id) ON DELETE CASCADE;


--
-- Name: projet_demare_detaille projet_demare_detaille_id_projet_demare_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.projet_demare_detaille
    ADD CONSTRAINT projet_demare_detaille_id_projet_demare_fkey FOREIGN KEY (id_projet_demare) REFERENCES public.projet_demare(id);


--
-- Name: projet projet_id_categorie_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.projet
    ADD CONSTRAINT projet_id_categorie_fkey FOREIGN KEY (id_categorie) REFERENCES public.categorie(id);


--
-- Name: projet projet_id_type_intervention_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.projet
    ADD CONSTRAINT projet_id_type_intervention_fkey FOREIGN KEY (id_type_intervention) REFERENCES public.type_intervention(id);


--
-- Name: projet projet_id_type_projet_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.projet
    ADD CONSTRAINT projet_id_type_projet_fkey FOREIGN KEY (id_type_projet) REFERENCES public.type_projet(id);


--
-- Name: projet_travailler_detaille projet_travailler_detaille_id_projects_travailler_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.projet_travailler_detaille
    ADD CONSTRAINT projet_travailler_detaille_id_projects_travailler_fkey FOREIGN KEY (id_projects_travailler) REFERENCES public.projects_travailler(id);


--
-- Name: utilisateur_concerner utilisateur_concerner_id_calandrier_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.utilisateur_concerner
    ADD CONSTRAINT utilisateur_concerner_id_calandrier_fkey FOREIGN KEY (id_calandrier) REFERENCES public.calandrier_preparation(id);


--
-- Name: utilisateur_concerner_workflow utilisateur_concerner_workflow_id_workflow_validation_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.utilisateur_concerner_workflow
    ADD CONSTRAINT utilisateur_concerner_workflow_id_workflow_validation_fkey FOREIGN KEY (id_workflow_validation) REFERENCES public.workflow_validation(id);


--
-- Name: workflow_validation workflow_validation_id_parent_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.workflow_validation
    ADD CONSTRAINT workflow_validation_id_parent_fkey FOREIGN KEY (id_parent) REFERENCES public.workflow_validation(id);


--
-- Name: workflow_validation workflow_validation_id_projects_travailler_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.workflow_validation
    ADD CONSTRAINT workflow_validation_id_projects_travailler_fkey FOREIGN KEY (id_projects_travailler) REFERENCES public.projects_travailler(id);


--
-- PostgreSQL database dump complete
--

