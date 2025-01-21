<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TablePagination from "@/Pages/Outlet/TablePagination.vue";
import { Head } from "@inertiajs/vue3";
import AddButton from "@/Components/AddButton.vue";
</script>

<template>
    <Head title="Brand" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
            >
                Outlet List
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <div
                    class="bg-white p-4 shadow sm:rounded-lg sm:p-8 dark:bg-gray-800"
                >
                    <div class="py-5">
                        <AddButton :href="route('outlet.create')">Add Data</AddButton>
                    </div>

                    <TablePagination></TablePagination>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
