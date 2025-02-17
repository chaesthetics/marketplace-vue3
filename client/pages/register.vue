<script lang="ts" setup>
import type { FormSubmitEvent } from '#ui/types'
import * as Yup from 'yup'

interface State {
    name: string | undefined;
    email: string | undefined;
    password: string | undefined;
}

const form = ref()

const state = reactive<State>({
    name: undefined,
    email: undefined,
    password: undefined,
});

const schema = Yup.object({
    name: Yup.string().min(3, "Please enter your fullname").required("This field is required"),
    email: Yup.string().email("Please enter valid email").required("This field is required"),
    password: Yup.string().min(8, "Password must be 8 characters").required("This field is required"),
});

const handleSubmit = async(
    event: FormSubmitEvent<{ name: string; email: string; password: string }>,
) => {
    const { name, email, password } = event.data;
    console.log(name);
}

</script>
<template>
<main class="flex min-h-screen justify-center items-center">
    <div
      class="flex flex-col space-y-6 items-center w-full max-w-sm px-6 py-12 mx-auto bg-white shadow-sm sm:max-w-md h-3/4 ring-1 ring-neutral-300 sm:rounded-xl sm:px-12 lg:px-6"
    >
        <img
          src="../assets/logo1.png"
          class="w-[12rem] object-cover mx-auto rounded-md"
        />
        <span class="text-lg">Register Now</span>
        <UForm class="w-full space-y-2"
            :state="state"
            :schema="schema"
            ref="form"
            @submit="handleSubmit"
        >
            <UFormGroup label="Name" name="name">
                <UInput 
                    v-model="state.name"
                />
            </UFormGroup>

            <UFormGroup label="Email" name="email">
                <UInput 
                    v-model="state.email"
                />
            </UFormGroup>

            <UFormGroup label="Password" name="password">
                <UInput 
                    type="password" 
                    v-model="state.password"
                />
            </UFormGroup>

            <UButton type="submit" class="w-full flex justify-center text-center">
                Submit
            </UButton>
        </UForm>
  </div>
</main>
</template>