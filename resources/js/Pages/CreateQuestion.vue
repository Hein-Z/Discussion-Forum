<template>
    <Master>
        <div class="card">
            <div class="card-title text-center mt-2 "><h3>Create Question</h3></div>
            <div class="card-body">
                <form action="" @submit.prevent="onCreate">
                    <input type="text" name="title" class="form-control mb-3" placeholder="title" v-model="title">
                    <p class="text-danger">{{ errors.title }}</p>
                    <textarea name="description" class="form-control mb-3" placeholder="description"
                              v-model="description"></textarea>
                    <p class="text-danger">{{ errors.description }}</p>
                    <div class="form-check form-check-inline" v-for="t in $page.props.tag">
                        <input class="form-check-input" type="checkbox" :value="t.id" :id="t.id" v-model="tags">
                        <label class="form-check-label" :for="t.id">
                            {{ t.name }}
                        </label>
                    </div>
                    <button type="submit" class="btn float-right mt-3 btn-success" :disabled="loading">
                        <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"
                              v-show="loading"></span>
                        {{ loading ? 'Wait...' : 'Register' }}
                    </button>
                </form>
            </div>
        </div>
    </Master>
</template>
<script>
import Master from './Layout/Master';

export default {
    name: 'createQuestion',
    props: {
        errors: Object
    },
    data() {
        return {
            loading: false,
            title: '',
            tags: [],
            description: '',
        }
    },
    methods: {
        onCreate() {
            this.loading = true;
            var data = new FormData();
            data.append("title", this.title);
            data.append("description", this.description);
            data.append("tags", this.tags);
            this.$inertia
                .post(this.route('question.store'), data)
                .then(_ => {
                    this.loading = false;
                    this.$toastr.s('successfully created');
                })
                .catch(err => this.loading = false);
        }
    },
    components: {
        Master
    }
}
</script>
