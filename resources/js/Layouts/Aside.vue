<template>
	<div class="card flex justify-center">
		<Menu :model="items" />
	</div>
</template>

<script setup>
import { Menu } from 'primevue';
import { ref } from 'vue';
const items = ref([
	{ label: 'Diploma Academico', icon: 'pi pi-plus' },
	{ label: 'Titulo Profesional', icon: 'pi pi-search' },
]);
</script>
