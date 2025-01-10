<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import routes from '@/routes';
</script>

<template>
	<div class="h-screen w-screen overflow-hidden">
		<header class="bold bg-gray-800 p-4 uppercase text-white">
			<h1>Departamento de Titulos</h1>
		</header>
		<div class="flex h-[calc(100vh-64px)]">
			<aside class="w-auto text-nowrap text-white">
				<ul class="bg-gray-800 p-2">
					<li
						class="border-b-gray-500"
						v-for="link in routes"
						:key="link.route"
						:class="{ 'bg-red-900': route().current(link.route) }"
					>
						<Link class="block w-full p-2" :href="route(link.route)">{{
							link.label
						}}</Link>
					</li>
				</ul>
			</aside>
			<main class="flex-1 overflow-hidden">
				<slot></slot>
			</main>
		</div>
	</div>
</template>
