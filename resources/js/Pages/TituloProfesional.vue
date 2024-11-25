<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm } from '@inertiajs/vue3';
import {
	Button,
	Dialog,
	FileUpload,
	FloatLabel,
	InputText,
	Message,
	RadioButton,
	Select,
	Toast,
} from 'primevue';
import { useToast } from 'primevue/usetoast';
import { ref, watch } from 'vue';
import searchPerson from './searchPerson';

const props = defineProps<{
	menciones: {
		nombre: string;
		carrera_id: number;
	}[];
	carreras: {
		nombre: string;
		id: number;
	}[];
}>();

interface Person {
	ci: string;
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
	// Agrega otros campos según sea necesario
}

const form = useForm({
	ci: '',
	nombres: '',
	apellido_paterno: '',
	apellido_materno: '',
	fecha_nacimiento: '',
	pais: '',
	departamento: '',
	provincia: '',
	facultad: '',
	localidad: '',
	fojas: '',
	libro: '',
	nivel: '',
	programa: '',
	mencion: '',
	file: null,
	sexo: '',
});

const programas = ref<Person[]>([]);
const selectedPrograma = ref<string>('');
const isLoading = ref<boolean>(false);
const isReadonly = ref<boolean>(false);

const buscarPersona = async () => {
	isLoading.value = true;
	// @ts-ignore
	const result: Person[] = await searchPerson(form.ci);
	isLoading.value = false;
	if (result && result.length > 0) {
		programas.value = result;
		const person = result[0];
		selectedPrograma.value = person.programa;
		updateForm(person);
		isReadonly.value = true;
	} else {
		clearForm();
		isReadonly.value = false;
	}
};

const updateForm = (person: Person) => {
	form.nombres = person.nombres;
	form.apellido_paterno = person.paterno;
	form.apellido_materno = person.materno;
	form.fecha_nacimiento = person.fec_nacimiento;
	form.pais = person.pais;
	form.departamento = person.departamento;
	form.provincia = person.provincia;
	form.localidad = person.localidad;
	form.programa = person.programa;
	form.facultad = person.facultad;
	// Actualiza otros campos según sea necesario
};

const clearForm = () => {
	form.nombres = '';
	form.apellido_paterno = '';
	form.apellido_materno = '';
	form.fecha_nacimiento = '';
	form.pais = '';
	form.departamento = '';
	form.provincia = '';
	form.localidad = '';
	form.programa = '';
	form.fojas = '';
	form.libro = '';
	form.nivel = '';
	form.mencion = '';
	// Limpia otros campos según sea necesario
};

const onProgramaChange = () => {
	const selectedPerson = programas.value.find(
		(person) => person.programa === selectedPrograma.value,
	);
	if (selectedPerson) {
		updateForm(selectedPerson);
	}
};
const toast = useToast();
// @ts-ignore
const onFileSelect = (event) => {
	form.file = event.files[0];
};

const mencionDoalog = ref(false);
watch(
	() => form.mencion,
	(form) => {
		console.log(form);
	},
);
</script>

<template>
	<AuthenticatedLayout>
		<section class="w-1/2">
			<form
				@submit.prevent="form.post(route('titulo-profesional.store'))"
				class="grid grid-cols-1 gap-y-3"
			>
				<div class="flex w-full gap-x-3">
					<div class="flex-grow">
						<FloatLabel variant="on" class="w-full">
							<InputText
								class="w-full"
								id="ci"
								v-model="form.ci"
								:class="{ 'p-invalid': form.errors.ci }"
							/>
							<label for="ci">CI</label>
						</FloatLabel>
						<Message
							size="small"
							variant="simple"
							v-if="form.errors.ci"
							severity="error"
						>
							{{ form.errors.ci }}
						</Message>
					</div>
					<Button @click="buscarPersona" :loading="isLoading" label="Buscar" />
				</div>

				<div class="grid grid-cols-1 gap-x-3">
					<FloatLabel variant="on">
						<Select
							id="programa"
							class="w-full"
							v-model="selectedPrograma"
							:options="programas.map((p) => p.programa)"
							@change="onProgramaChange"
							:class="{ 'p-invalid': form.errors.programa }"
						/>
						<label for="programa">Programa</label>
					</FloatLabel>
					<Message
						v-if="form.errors.programa"
						severity="error"
						size="small"
						variant="simple"
					>
						{{ form.errors.programa }}
					</Message>
				</div>

				<FloatLabel variant="on">
					<InputText
						class="w-full"
						id="nombres"
						v-model="form.nombres"
						:readonly="isReadonly"
						:class="{ 'p-invalid': form.errors.nombres }"
					/>
					<label for="nombres">Nombres</label>
				</FloatLabel>
				<Message
					v-if="form.errors.nombres"
					severity="error"
					size="small"
					variant="simple"
				>
					{{ form.errors.nombres }}
				</Message>
				<div class="grid grid-cols-2 gap-x-3">
					<div>
						<FloatLabel variant="on">
							<InputText
								class="w-full"
								id="apellido_paterno"
								v-model="form.apellido_paterno"
								:readonly="isReadonly"
								:class="{ 'p-invalid': form.errors.apellido_paterno }"
							/>
							<label for="apellido_paterno">Apellido Paterno</label>
						</FloatLabel>
						<Message
							v-if="form.errors.apellido_paterno"
							severity="error"
							size="small"
							variant="simple"
						>
							{{ form.errors.apellido_paterno }}
						</Message>
					</div>
					<div>
						<FloatLabel variant="on">
							<InputText
								class="w-full"
								id="apellido_materno"
								v-model="form.apellido_materno"
								:readonly="isReadonly"
								:class="{ 'p-invalid': form.errors.apellido_materno }"
							/>
							<label for="apellido_materno">Apellido Materno</label>
						</FloatLabel>
						<Message v-if="form.errors.apellido_materno" severity="error">
							{{ form.errors.apellido_materno }}
						</Message>
					</div>
				</div>
				<div class="grid grid-cols-3 gap-x-3">
					<div>
						<FloatLabel variant="on">
							<InputText
								class="w-full"
								id="fecha_nacimiento"
								v-model="form.fecha_nacimiento"
								:readonly="isReadonly"
								:class="{ 'p-invalid': form.errors.fecha_nacimiento }"
							/>
							<label for="fecha_nacimiento">Fecha de Nacimiento</label>
						</FloatLabel>
						<Message v-if="form.errors.fecha_nacimiento" severity="error">
							{{ form.errors.fecha_nacimiento }}
						</Message>
					</div>
					<div>
						<FloatLabel variant="on">
							<InputText
								class="w-full"
								id="pais"
								v-model="form.pais"
								:readonly="isReadonly"
								:class="{ 'p-invalid': form.errors.pais }"
							/>
							<label for="pais">Pais</label>
						</FloatLabel>
						<Message
							v-if="form.errors.pais"
							severity="error"
							variant="simple"
							size="small"
						>
							{{ form.errors.pais }}
						</Message>
					</div>

					<div>
						<FloatLabel variant="on">
							<InputText
								class="w-full"
								id="departamento"
								v-model="form.departamento"
								:readonly="isReadonly"
								:class="{ 'p-invalid': form.errors.departamento }"
							/>
							<label for="departamento">Departamento</label>
						</FloatLabel>
						<Message
							v-if="form.errors.departamento"
							severity="error"
							variant="simple"
							size="small"
						>
							{{ form.errors.departamento }}
						</Message>
					</div>
				</div>
				<div class="grid grid-cols-2 gap-x-3">
					<div>
						<FloatLabel variant="on">
							<InputText
								class="w-full"
								id="provincia"
								v-model="form.provincia"
								:readonly="isReadonly"
								:class="{ 'p-invalid': form.errors.provincia }"
							/>
							<label for="provincia">Provincia</label>
						</FloatLabel>
						<Message
							v-if="form.errors.provincia"
							severity="error"
							variant="simple"
							size="small"
						>
							{{ form.errors.provincia }}
						</Message>
					</div>
					<div>
						<FloatLabel variant="on">
							<InputText
								class="w-full"
								id="localidad"
								v-model="form.localidad"
								:readonly="isReadonly"
								:class="{ 'p-invalid': form.errors.localidad }"
							/>
							<label for="localidad">Localidad</label>
						</FloatLabel>
						<Message
							v-if="form.errors.localidad"
							severity="error"
							variant="simple"
							size="small"
						>
							{{ form.errors.localidad }}
						</Message>
					</div>
				</div>

				<div>
					<div class="flex flex-wrap gap-x-8">
						<div class="flex items-center gap-2">
							<RadioButton
								inputId="masculino"
								v-model="form.sexo"
								value="MASCULINO"
							/>
							<label for="masculino">Masculino</label>
						</div>
						<div class="flex items-center gap-2">
							<RadioButton
								inputId="femenino"
								v-model="form.sexo"
								name="FEMENINO"
								value="FEMENINO"
							/>
							<label for="femenino">Femenino</label>
						</div>
						<div>
							<RadioButton
								inputId="otro"
								v-model="form.sexo"
								name="OTRO"
								value="OTRO"
							/>
							<label for="otro">Otro</label>
						</div>
					</div>
					<Message
						v-if="form.errors.sexo"
						severity="error"
						variant="simple"
						size="small"
					>
						{{ form.errors.sexo }}
					</Message>
				</div>
				<div class="grid grid-cols-3 gap-x-3">
					<div>
						<FloatLabel variant="on">
							<InputText
								id="fojas"
								class="w-full"
								v-model="form.fojas"
								:class="{ 'p-invalid': form.errors.fojas }"
							/>
							<label for="fojas">Fojas</label>
						</FloatLabel>
						<Message
							v-if="form.errors.fojas"
							severity="error"
							variant="simple"
							size="small"
						>
							{{ form.errors.fojas }}
						</Message>
					</div>
					<div>
						<FloatLabel variant="on">
							<InputText
								class="w-full"
								id="libro"
								v-model="form.libro"
								:class="{ 'p-invalid': form.errors.libro }"
							/>
							<label for="libro">Libro</label>
						</FloatLabel>
						<Message
							v-if="form.errors.libro"
							severity="error"
							variant="simple"
							size="small"
						>
							{{ form.errors.libro }}
						</Message>
					</div>
					<div>
						<FloatLabel variant="on">
							<Select
								class="w-full"
								id="nivel"
								v-model="form.nivel"
								:options="['Licenciatura']"
								:class="{ 'p-invalid': form.errors.nivel }"
							/>
							<label for="nivel">Nivel</label>
						</FloatLabel>
						<Message
							v-if="form.errors.nivel"
							severity="error"
							size="small"
							variant="simple"
						>
							{{ form.errors.nivel }}
						</Message>
					</div>
				</div>
				<div class="grid grid-cols-1 gap-x-3">
					<FloatLabel variant="on">
						<Select
							id="mencion"
							class="w-full"
							v-model="form.mencion"
							:options="props.menciones.map((m) => m.nombre)"
							:class="{ 'p-invalid': form.errors.mencion }"
						>
							<template #footer>
								<div class="">
									<Button
										label="Agregar +"
										fluid
										severity="secondary"
										text
										size="small"
										@click="mencionDoalog = true"
									/>
								</div>
							</template>
						</Select>
						<label for="mencion">Mención</label>
						<Dialog
							v-model:visible="mencionDoalog"
							modal
							header="Edit Profile"
							:style="{ width: '25rem' }"
						>
							<span class="text-surface-500 dark:text-surface-400 mb-8 block"
								>Añadir mencion</span
							>
							<div class="mb-4 flex items-center gap-4">
								<label for="carrera_tpn" class="w-24 font-semibold"
									>Carrera</label
								>
								<Select
									id="carrera_tpn"
									class="flex-auto"
									:options="props.carreras.map((c) => c.nombre)"
								/>
							</div>
							<div class="mb-8 flex items-center gap-4">
								<label for="mencion_tpn" class="w-24 font-semibold"
									>Mencion Titulo Provision Nacional</label
								>
								<InputText
									id="email"
									class="flex-auto"
									autocomplete="off"
									name="mencion_tpn"
								/>
							</div>
							<div class="flex justify-end gap-2">
								<Button
									type="button"
									label="Cancel"
									severity="secondary"
									@click="mencionDoalog = false"
								></Button>
								<Button
									type="button"
									label="Save"
									@click="mencionDoalog = false"
								></Button>
							</div>
						</Dialog>
					</FloatLabel>
					<Message
						v-if="form.errors.mencion"
						severity="error"
						size="small"
						variant="simple"
					>
						{{ form.errors.mencion }}
					</Message>
				</div>
				<div>
					<div class="card flex justify-center">
						<Toast />
						<FileUpload
							ref="fileupload"
							mode="basic"
							name="file"
							accept=".pdf"
							:maxFileSize="10000000"
							@select="onFileSelect"
						/>
					</div>
				</div>
				<Button type="submit" label="Guardar" class="mt-4" />
			</form>
			<div>
				{{ form.errors }}
			</div>
		</section>
	</AuthenticatedLayout>
</template>

<style>
.p-invalid {
	border-color: red;
}
</style>
