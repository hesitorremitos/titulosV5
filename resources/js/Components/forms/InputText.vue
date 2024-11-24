<script setup lang="ts">
import { FloatLabel, InputText } from 'primevue';
</script>

<template>
	<FloatLabel>
		<InputText v-bind="$attrs" v-model="modelValue" />
		<label>{{ label }}</label>
	</FloatLabel>
</template>
