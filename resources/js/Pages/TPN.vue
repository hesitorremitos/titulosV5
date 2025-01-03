<script setup lang="ts">
import MainLayout from '@/Layouts/MainLayout.vue';
import usePersonStore from '@/stores/usePersonStore';
import { ref } from 'vue';
const person = usePersonStore();
const ci = ref<string>('');
defineOptions({
	layout: MainLayout,
});
</script>

<template>
	<h1>TPN</h1>
	<form @submit.prevent="person.setPerson(ci)">
		<input type="text" v-model="ci" placeholder="Carnet de identidad" />
		<button type="submit">Buscar</button>
	</form>
	<p v-if="person.loading">Cargando...</p>

	<p>
		{{ person.nombres }}
	</p>
	<p>
		{{ person.finded }}
	</p>
</template>
