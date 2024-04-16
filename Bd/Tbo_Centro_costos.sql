-- Table: centro_costos

-- DROP TABLE centro_costos;

CREATE TABLE centro_costos
(
  codigo character varying(5) NOT NULL,
  nombre character varying(20),
  CONSTRAINT centro_costos_pkey PRIMARY KEY (codigo)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE centro_costos
  OWNER TO postgres;
