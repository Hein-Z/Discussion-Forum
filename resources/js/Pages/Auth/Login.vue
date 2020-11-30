<template>
    <div class="row">
        <div class="card mt-5 col-md-4 offset-4">
            <div class="card-header">Login Form
            </div>
            <div class="card-body">
                <form action="" @submit.prevent="login">
                    <div class="form-group">
                        <label for="Email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" v-model="email">
                        <small class="text-danger">{{ errors.email }}</small>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control" v-model="password">
                        <small class="text-danger">{{ errors.password }}</small>
                    </div>
                    <small class="text-danger text-center"> {{$page.props.flash.error}}</small>
                    <button type="submit" class="btn btn-block btn-success" :disabled="loading">
                        <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"
                              v-show="loading"></span>
                        {{ loading ? 'Wait...' : 'Submit' }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: "login",
    props: {
        errors: Object,
        failMsg:String
    },
    data() {
        return {
            email: null,
            password: null,
            loading: false
        }
    },
    methods: {
        login() {
            this.loading = true
            var data = new FormData();
            data.append('email', this.email);
            data.append('password', this.password);

            this.$inertia.post('/login', data)
                .then(_ => this.loading = false).catch(err => this.loading = false)
        }
    }
};
</script>
