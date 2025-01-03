<script setup lang="ts">
import {
	Button,
	FileUpload,
	FloatLabel,
	InputText,
	Message,
	Select,
	Toast,
} from 'primevue';

const props = defineProps<{
	form: any;
	programas: any[];
	selectedPrograma: string;
	isLoading: boolean;
	isReadonly: boolean;
	buscarPersona: () => void;
	onProgramaChange: () => void;
	onFileSelect: (event: any) => void;
	menciones: any[];
	mencionDoalog: boolean;
}>();
</script>

<template>
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
		<!-- ...existing code for other form fields... -->
		<div class="grid grid-cols-1 gap-x-3">
			<FloatLabel variant="on">
				<Select
					id="mencion"
					class="w-full"
					v-model="form.mencion"
					:options="menciones.map((m) => m.nombre)"
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
</template>
