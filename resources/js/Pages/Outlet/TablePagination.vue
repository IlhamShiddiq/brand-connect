<template>
    <div>
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto bg-white border-separate border-spacing-0 rounded-lg shadow-md">
                <thead>
                <tr class="bg-gray-100 text-left text-sm font-semibold text-gray-700">
                    <th class="px-6 py-3 border-b">Name</th>
                    <th class="px-6 py-3 border-b">Brand</th>
                    <th class="px-6 py-3 border-b">Description</th>
                    <th class="px-6 py-3 border-b">Action</th>
                </tr>
                </thead>
                <tbody>
                <tr class="text-sm" v-for="outlet in outlets.data" :key="outlet.id">
                    <td class="px-6 py-4 border-b">{{ outlet.name }}</td>
                    <td class="px-6 py-4 border-b">{{ outlet?.brand?.name }}</td>
                    <td class="px-6 py-4 border-b">{{  outlet.description }}</td>
                    <td class="px-6 py-4 border-b">
                        <button @click="editOutlet(outlet.id)" class="mx-2 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Edit</button>
                        <button @click="deleteOutlet(outlet.id)" class="mx-2 px-4 py-2 bg-red-600 text-white rounded-md hover:bg-blue-700">Delete</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="flex my-4 items-center justify-center">
            <TailwindPagination
                :data="outlets"
                @pagination-change-page="getResults"
            />
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { TailwindPagination } from 'laravel-vue-pagination';
import { useForm } from "@inertiajs/vue3";
import { Inertia } from '@inertiajs/inertia';

const outlets = ref({});
const getResults = async (page = 1) => {
    const response = await axios.get(`http://localhost:8000/api/outlets?paginate=true&page=${page}`);
    outlets.value = response.data.data
}

getResults();

const editOutlet = (id) => {
    Inertia.visit(route('outlet.edit', id));
};

const deleteOutlet = (id) => {
    const form = useForm({
        outletId: id
    });

    form.delete(route('outlet.destroy', form.outletId), {
        onSuccess: () => {
            getResults();
        }
    });
}
</script>
