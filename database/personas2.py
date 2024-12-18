import pandas as pd
import sqlite3
from rich import print


# Nombre del archivo CSV sin la terminación .csv
CSV_FILE = "PERSONAS2"
DATABASE = "database.sqlite"

# Define los campos
CI = "CI"
NOMBRE = "NOMBRE"
PATERNO = "PATERNO"
MATERNO = "MATERNO"
LUGAR_NACIMIENTO = "LOCALIDAD"
SEXO = "SEXO"
FECHA_NACIMIENTO = "FECHA_NACIMIENTO"

FECHA_EMISION = "FECHA_EMISION"
NRO_DOCUMENTO = "NRO_DOCUMENTO"
FOJAS = "FOJAS"
LIBRO = "LIBRO"
MENCION_ID = "MENCION_ID"
MENCION = "MENCION"
GRADUACION = "GRADUACION_ID"
OBSERVACIONES = "OBSERVACIONES"


def leer_csv(filepath):
    return pd.read_csv(filepath)


def conectar_db(db_name):
    return sqlite3.connect(db_name)


def comprobar_persona(cursor, ci):
    cursor.execute("SELECT COUNT(*) FROM PERSONAS WHERE ci = ?", (ci,))
    return cursor.fetchone()[0] > 0


def insertar_persona(cursor, row):
    cursor.execute(
        """
        INSERT INTO PERSONAS (ci, nombres, paterno, materno, fecha_nacimiento, localidad, genero)
        VALUES (?, ?, ?, ?, ?, ?, ?)
        """,
        (
            row[CI],
            row[NOMBRE],
            row[PATERNO],
            row[MATERNO],
            row[FECHA_NACIMIENTO],
            row[LUGAR_NACIMIENTO],
            row[SEXO],
        ),
    )


def insertar_documento(cursor, row):
    cursor.execute(
        """
        INSERT INTO DIPLOMA_ACADEMICOS (ci, fecha_emision, nro_documento, fojas, libro, mencion_da_id, graduacion_ID, observaciones, file_dir)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        """,
        (
            row[CI],
            row[FECHA_EMISION],
            row[NRO_DOCUMENTO],
            row[FOJAS],
            row[LIBRO],
            row[MENCION_ID],
            # Si no se encuentra graduacion None
            row.get(GRADUACION, None),
            row[OBSERVACIONES],
            row[MENCION],
        ),
    )


def guardar_completado(data, filepath):
    data.to_csv(filepath, index=False, header=True)


def guardar_errores(data, filepath):
    data.to_csv(filepath, index=False, header=True)


def main():
    data = leer_csv(CSV_FILE + ".csv")
    conn = conectar_db(DATABASE)
    cursor = conn.cursor()

    errores = []
    success = []
    for index, row in data.iterrows():
        print(f"[blue]Procesando fila {index}:[/blue]")
        try:
            if comprobar_persona(cursor, row[CI]):
                print(f"[yellow]El CI: {row[CI]} ya existe[/yellow]")
            else:
                insertar_persona(cursor, row)
                print(f"[green]Persona con CI: {row[CI]} insertada[/green]")
            insertar_documento(cursor, row)
            success.append(row)
        except Exception as e:
            print("[red]ERROR: [/red]", end="")
            print(e)
            errores.append(row)
        # Imprimir línea de separación
        print("")
    conn.commit()
    conn.close()

    guardar_completado(pd.DataFrame(success), CSV_FILE + ".success.csv")
    guardar_errores(pd.DataFrame(errores, columns=data.columns), CSV_FILE + ".csv")


if __name__ == "__main__":
    main()
