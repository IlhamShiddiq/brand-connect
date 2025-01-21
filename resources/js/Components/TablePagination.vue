<template>
    <div>
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto bg-white border-separate border-spacing-0 rounded-lg shadow-md">
                <thead>
                <tr class="bg-gray-100 text-left text-sm font-semibold text-gray-700">
                    <th class="px-6 py-3 border-b">Name</th>
                    <th class="px-6 py-3 border-b">Description</th>
                    <th class="px-6 py-3 border-b">Action</th>
                </tr>
                </thead>
                <tbody>
                <tr class="text-sm" v-for="brand in brands.data" :key="brand.id">
                    <td class="px-6 py-4 border-b">{{ brand.name }}</td>
                    <td class="px-6 py-4 border-b">{{  brand.description }}</td>
                    <td class="px-6 py-4 border-b">
                        <button @click="editBrand(brand.id)" class="mx-2 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Edit</button>
                        <button @click="deleteBrand(brand.id)" class="mx-2 px-4 py-2 bg-red-600 text-white rounded-md hover:bg-blue-700">Delete</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="flex my-4 items-center justify-center">
            <TailwindPagination
                :data="brands"
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

const brands = ref({});
const getResults = async (page = 1) => {
    const response = await axios.get(`http://localhost:8000/api/brands?paginate=true&page=${page}`);
    brands.value = response.data
}

getResults();

const editBrand = (id) => {
    Inertia.visit(route('brand.edit', id));
};

const deleteBrand = (id) => {
    const form = useForm({
        brandId: id
    });

    form.delete(route('brand.destroy', form.brandId), {
        onSuccess: () => {
            getResults();
        }
    });
}
</script>
