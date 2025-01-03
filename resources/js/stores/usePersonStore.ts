import axios from 'axios';
import { defineStore } from 'pinia';
interface Person {
	paterno: string;
	materno: string;
	nombres: string;
	nro_dip: string;
	genero: string;
	fec_nacimieno: string;
	pais: string;
	departamento: string;
	provincia: string;
	localidad: string;
	programa: string;
	facultad: string;
	decano_nombres: string;
	modalidad_graduacion: string;
}

interface PersonState extends Person {
	loading: boolean;
	finded: boolean;
}

const usePersonStore = defineStore('person', {
	state: (): PersonState => ({
		paterno: '',
		materno: '',
		nombres: '',
		nro_dip: '',
		genero: '',
		fec_nacimieno: '',
		pais: '',
		departamento: '',
		provincia: '',
		localidad: '',
		programa: '',
		facultad: '',
		decano_nombres: '',
		modalidad_graduacion: '',
		loading: false,
		finded: false,
	}),
	actions: {
		setPerson(ci: string) {
			if (this.loading) return;
			this.loading = true;
			if (ci == null) {
				this.loading = false;
				return;
			}
			axios
				.post<Person[]>('https://apititulos.uatf.edu.bo/api/datos', {
					ru: `'${ci}'`,
				})
				.then((response) => {
					const data = response.data;
					if (data.length > 0) {
						const person = data[0];
						this.paterno = person.paterno;
						this.materno = person.materno;
						this.nombres = person.nombres;
						this.nro_dip = person.nro_dip;
						this.genero = person.genero;
						this.fec_nacimieno = person.fec_nacimieno;
						this.pais = person.pais;
						this.departamento = person.departamento;
						this.provincia = person.provincia;
						this.localidad = person.localidad;
						this.programa = person.programa;
						this.facultad = person.facultad;
						this.decano_nombres = person.decano_nombres;
						this.modalidad_graduacion = person.modalidad_graduacion;
						this.finded = true;
					} else {
						// reset all states
						this.$reset();
					}
					this.loading = false;
				})
				.catch((error) => {
					console.error('Error fetching student:', error);
					this.loading = false;
				});
		},
	},
});

export default usePersonStore;
