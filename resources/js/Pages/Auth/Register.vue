<template>
    <div class="row">
        <div class="card mt-5 col-md-4 offset-4">
            <div class="card-header">Register Form</div>
            <div class="card-body">
                <form action="" @submit.prevent="onRegister">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input
                            type="name"
                            name="name"
                            id="name"
                            class="form-control"
                            v-model="name"
                        />
                        <small class="text-danger">{{ errors.name }}</small>
                    </div>
                    <div class="form-group">
                        <label for="Email">Email</label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            class="form-control"
                            v-model="email"
                        />
                        <small class="text-danger">{{ errors.email }}</small>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="form-control"
                            v-model="password"
                        />
                        <small class="text-danger">{{ errors.password }}</small>
                    </div>
                    <div class="form-group">
                        <label for="image">Avatar</label>
                        <input
                            type="file"
                            name="image"
                            id="image"
                            class="form-control"
                            @change="uploadImage"
                        />
                        <small class="text-danger">{{ errors.image }}</small>
                    </div>
                    <button type="submit" class="btn btn-block btn-success" :disabled="loading">
                        <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" v-show="loading"></span>
                        {{loading?'Wait...':'Register'}}
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        errors: Object
    },
    name: "Register",
    data() {
        return {
            name: null,
            email: null,
            password: null,
            image: null,
            loading: false
        };
    },
    methods: {
        uploadImage(e) {
            this.image = e.target.files[0];
        },
        onRegister() {
            this.loading = true;
            var data = new FormData();
            data.append("name", this.name);
            data.append("email", this.email);
            data.append("password", this.password);
            data.append("image", this.image);
            this.$inertia
                .post("/register", data)
                .then(_ => this.loading = false)
                .catch(err => this.loading = false);
        }
    }
};
</script>
