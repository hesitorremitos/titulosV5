import axios from 'axios';

interface Person {
    nombres: string;
		paterno: string;
		materno: string;
    fec_nacimiento: string;
    pais: string;
    departamento: string;
    provincia: string;
    localidad: string;
    programa: string;
    facultad: string;
    decano_nombres: string;
    modalidad_graduacion: string;
    nota_graduacion: number;
}

async function searchPerson(ru: string): Promise<Person[] | null> {
    if (ru == null) {
        return null;
    }
    try {
        const response = await axios.post<Person[]>('https://apititulos.uatf.edu.bo/api/datos', {
            ru: `'${ru}'`, // Aseguramos que el parámetro se envíe como string
        });

        const data = response.data;

        return data;
    } catch (error) {
        console.error('Error fetching student:', error);
        return null;
    }
}


export default searchPerson;
export type { Person };
