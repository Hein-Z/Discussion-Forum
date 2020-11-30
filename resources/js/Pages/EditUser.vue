<template>
<Master>
    <div class="card">
        <div class="alert alert-success alert-dismissible fade show" v-show="$page.props.flash.success" role="alert">
            <strong>{{$page.props.flash.success}}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="card-header">Edit Profile</div>
        <div class="card-body">
            <form action="" @submit.prevent="onEdit">
                <div class="form-group">
                    <label for="name">Nammastere</label>
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
                    <img :src="$page.props.auth_user.image" width="70px" :alt="$page.props.auth_user.image">
                    <input
                        type="file"
                        name="image"
                        id="image"
                        class="form-control"
                        @change="uploadImage"
                    />
                    <small class="text-danger">{{ image&&errors.image?errors.image:'' }}</small>
                </div>
                <button type="submit" class="btn btn-block btn-success" :disabled="loading">
                    <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" v-show="loading"></span>
                    {{loading?'Wait...':'Register'}}
                </button>
            </form>
        </div>
    </div>
</Master>
</template>
<script>
import Master from "./Layout/Master";

export default {
    name: 'EditUser',
    components: {
        Master
    },
    props: {
        errors: Object
    },
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
            this.errors.image=null
            this.image = e.target.files[0];
        },
        onEdit() {
            this.loading = true;
            var data = new FormData();
            data.append("name", this.name);
            data.append("email", this.email);
            data.append("password", this.password);
            data.append("image", this.image);
            this.$inertia
                .post("/profile/edit", data)
                .then(_ => this.loading = false)
                .catch(err => this.loading = false);
        }
    },
    created() {
        const {name,email}=this.$page.props.auth_user;
        this.name=name;
        this.email=email;
    }
}
</script>
