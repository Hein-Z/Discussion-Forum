<template>
    <Master>
        <div class="card">
            <div class="card-body" v-for="(q,index) in questions.data" :key="q.id">{{ q.title }}
                <div class="card-action d-inline float-right">
                    <inertia-link class="btn btn-sm text-primary p-2 px-4"
                                  :href="route('question.detail',[q.slug,q.id])">
                        <i class="fas fa-info"></i>
                    </inertia-link>
                    <a @click="deleteQuestion(index,q.id)" class="text-danger"><i class="fas fa-trash"></i></a></div>
            </div>
        </div>
        <Pagination :links="questions.links" class="mt-3"></Pagination>
    </Master>
</template>
<script>
import Master from "./Layout/Master";
import axios from 'axios';
import Pagination from "./Layout/Pagination";

export default {
    name: 'UserQuestion',
    data() {
        return {
            questions: null
        }
    },
    components: {
        Master,
        Pagination
    },
    methods: {
        deleteQuestion(index, id) {
            axios.get(this.route('question.delete', id))
                .then(res => {
                    if (res.data.success) {
                        this.questions.data.splice(index, 1);
                        this.$toastr.s('successfully deleted');
                    }
                }).catch(e => this.$toastr.e('something wrong!'));
        }
    },
    created() {
        this.questions = this.$page.props.questions;
    }
}
</script>
