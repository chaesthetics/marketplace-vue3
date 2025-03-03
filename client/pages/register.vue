<script lang="ts" setup>
import type { FormSubmitEvent } from '#ui/types'
import * as Yup from 'yup'
import { useAuthStore } from '#imports';
import { ResponseError } from "~/errors/response-error";
import { handleError } from "~/helpers/helpers";
import Vanta from "~/components/Vanta.vue";

interface State {
    name: string | undefined;
    email: string | undefined;
    password: string | undefined;
}

const form = ref();
const loading = ref(false);
const auth = useAuthStore();

const state = reactive<State>({
    name: undefined,
    email: undefined,
    password: undefined,
});

const { displayToast } = getToastMessage();

const schema = Yup.object({
    name: Yup.string().min(3, "Please enter your fullname").required("This field is required"),
    email: Yup.string().email("Please enter valid email").required("This field is required"),
    password: Yup.string().min(8, "Password must be 8 characters").required("This field is required"),
});

const handleSubmit = async(
    event: FormSubmitEvent<{ name: string; email: string; password: string }>,
) => {
    const { name, email, password } = event.data;
    loading.value = true;
    try{
        await auth.register({name, email, password});
        loading.value = false;
        displayToast("Registration successful", "green");
        Object.assign(state, { name: "", email: "", password: "" });
    } catch(error){
        if (error instanceof ResponseError) {
            if (
            error.message.startsWith("The email has already been taken.") 
            ){
                loading.value = false;
                return displayToast(error.message, "red");
            }
            handleError(error.message, error.status);
        }else{
            return showLoginFormErrors(error as Error, form);
        }
        handleError(error.message, error.status);
        loading.value = false;
    }
}
</script>
<template>
<main class="flex min-h-screen justify-center items-center">
    <ClientOnly>
        <Vanta />
    </ClientOnly>
    <div
      class="flex flex-col space-y-6 items-center w-full max-w-sm px-6 py-12 mx-auto bg-white shadow-sm sm:max-w-md h-3/4 ring-1 ring-neutral-300 sm:rounded-xl sm:px-12 lg:px-6"
    >
        <img
          src="../assets/logo1.png"
          class="w-[10rem] object-cover mx-auto rounded-md"
        />
        <span class="text-md">Create your account</span>
        <UForm class="w-full space-y-2"
            :state="state"
            :schema="schema"
            ref="form"
            @submit="handleSubmit"
        >
            <UFormGroup label="Name" name="name">
                <UInput 
                    v-model="state.name"
                    autocomplete="off"
                />
            </UFormGroup>

            <UFormGroup label="Email" name="email">
                <UInput 
                    v-model="state.email"
                    autocomplete="off"
                />
            </UFormGroup>

            <UFormGroup label="Password" name="password">
                <UInput 
                    type="password" 
                    v-model="state.password"
                />
            </UFormGroup>

            <UButton 
                type="submit" 
                class="w-full flex justify-center text-center"
                :loading="loading"
            >
                Submit
            </UButton>
        </UForm>
  </div>
</main>
</template>

<style scoped>
</style>