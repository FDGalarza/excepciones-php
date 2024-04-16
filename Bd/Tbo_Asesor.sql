-- Table: asesor

-- DROP TABLE asesor;

CREATE TABLE asesor
(
  doc_identidad character varying(20) NOT NULL,
  nom_1 character varying(20),
  nom_2 character varying(20),
  ape_1 character varying(20),
  ape_2 character varying(20),
  centro_costos character varying(30),
  estado_contraro character varying(50),
  excep character varying(20),
  CONSTRAINT clave PRIMARY KEY (doc_identidad)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE asesor
  OWNER TO postgres;
