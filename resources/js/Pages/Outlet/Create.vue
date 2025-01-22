<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm, usePage } from "@inertiajs/vue3";
import { ref } from "vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";

const name = ref(null);
const description = ref(null);
const brandId = ref(null);
const phoneNumber = ref(null);
const address = ref(null);
const latitude = ref(null);
const longitude = ref(null);

const props = defineProps({
    brands: Object,
})

const form = useForm({
    brand_id: '',
    name: '',
    phone_number: '',
    description: '',
    address: '',
    latitude: '',
    longitude: '',
});

const createBrand = () => {
    form.post(route('outlet.store'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            name.value.focus();
        },
        onError: () => {
            if (form.errors.brand_id) {
                form.reset('brandId');
                brandId.value.focus();
            }
            if (form.errors.name) {
                form.reset('name');
                name.value.focus();
            }
            if (form.errors.phone_number) {
                form.reset('phoneNumber');
                phoneNumber.value.focus();
            }
            if (form.errors.description) {
                form.reset('description');
                description.value.focus();
            }
            if (form.errors.address) {
                form.reset('address');
                address.value.focus();
            }
            if (form.errors.latitude) {
                form.reset('latitude');
                latitude.value.focus();
            }
            if (form.errors.longitude) {
                form.reset('longitude');
                longitude.value.focus();
            }
        },
    })
};
</script>

<template>
    <Head title="Outlet" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
            >
                Add Outlet
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <div
                    class="bg-white p-4 shadow sm:rounded-lg sm:p-8 dark:bg-gray-800"
                >
                    <form @submit.prevent="createBrand" class="mt-6 space-y-6">
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <InputLabel for="brandId" value="Brand" />

                                <select
                                    id="brandId"
                                    v-model="form.brand_id"
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                >
                                    <option value="" disabled>Select a brand</option>
                                    <option v-for="brand in brands" :key="brand?.id" :value="brand?.id">
                                        {{ brand?.name }}
                                    </option>
                                </select>

                                <InputError
                                    :message="form.errors.brand_id"
                                    class="mt-2"
                                />
                            </div>

                            <div>
                                <InputLabel for="name" value="Name" />

                                <TextInput
                                    id="name"
                                    ref="name"
                                    v-model="form.name"
                                    type="text"
                                    class="mt-1 block w-full"
                                />

                                <InputError :message="form.errors.name" class="mt-2" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <InputLabel for="address" value="Address" />

                                <TextInput
                                    id="address"
                                    ref="address"
                                    v-model="form.address"
                                    type="text"
                                    class="mt-1 block w-full"
                                />

                                <InputError
                                    :message="form.errors.address"
                                    class="mt-2"
                                />
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <InputLabel for="phoneNumber" value="Phone Number" />

                                <TextInput
                                    id="phoneNumber"
                                    ref="phoneNumber"
                                    v-model="form.phone_number"
                                    type="text"
                                    class="mt-1 block w-full"
                                />

                                <InputError
                                    :message="form.errors.phone_number"
                                    class="mt-2"
                                />
                            </div>

                            <div>
                                <InputLabel for="description" value="Description" />

                                <TextInput
                                    id="description"
                                    ref="description"
                                    v-model="form.description"
                                    type="text"
                                    class="mt-1 block w-full"
                                />

                                <InputError :message="form.errors.description" class="mt-2" />
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <InputLabel for="latitude" value="Latitude" />

                                <TextInput
                                    id="latitude"
                                    ref="latitude"
                                    v-model="form.latitude"
                                    type="text"
                                    class="mt-1 block w-full"
                                />

                                <InputError
                                    :message="form.errors.latitude"
                                    class="mt-2"
                                />
                            </div>

                            <div>
                                <InputLabel for="longitude" value="Longitude" />

                                <TextInput
                                    id="longitude"
                                    ref="longitude"
                                    v-model="form.longitude"
                                    type="text"
                                    class="mt-1 block w-full"
                                />

                                <InputError :message="form.errors.longitude" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                            <Transition
                                enter-active-class="transition ease-in-out"
                                enter-from-class="opacity-0"
                                leave-active-class="transition ease-in-out"
                                leave-to-class="opacity-0"
                            >
                                <p
                                    v-if="form.recentlySuccessful"
                                    class="text-sm text-gray-600 dark:text-gray-400"
                                >
                                    Saved.
                                </p>
                            </Transition>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
select {
    max-height: 150px;
    overflow-y: auto;
}
</style>
