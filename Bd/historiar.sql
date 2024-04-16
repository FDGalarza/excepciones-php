-- Table: historiar

-- DROP TABLE historiar;

CREATE TABLE historiar
(
  doc_identidad character varying(15),
  excepcion character varying(10),
  contrato character varying(15),
  centro_costos character varying(30),
  usuario_modificacion character varying(50),
  fecha_modificacion timestamp with time zone
)
WITH (
  OIDS=FALSE
);
ALTER TABLE historiar
  OWNER TO postgres;
