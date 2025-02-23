import { useAuthStore } from "#imports";


const register = (data: any) => {

    const auth = useAuthStore();

    console.log("Register.ts has been called");
    console.log(auth?.user?.email);
}

export { register };
