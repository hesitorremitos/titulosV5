<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import routes from '@/routes';
</script>

<template>
	<div class="h-screen w-screen">
		<header class="bg-gray-800 p-4 text-white">
			<h1>My App {{ route().current() }}</h1>
		</header>
		<div class="flex">
			<aside class="w-auto text-white">
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
			<main>
				<slot></slot>
			</main>
		</div>
	</div>
</template>
