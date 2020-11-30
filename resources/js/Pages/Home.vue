<template>
    <Master>
        <div class="card promoting-card mb-2" v-for="(q,index) in questions.data" :key="q.id">

            <!-- Card content -->
            <div class="card-header d-flex flex-row " style="background-color: #4a5568">

                <!-- Avatar -->
                <img :src="q.user.image" class="rounded-circle mr-3"
                     height="50px" width="50px" alt="avatar">

                <!-- Content -->
                <div>
                    <h5 class="card-title text-success font-weight-bold h6 my-2">{{ q.user.name }}</h5>
                    <p class="card-text"><i class="far fa-clock pr-2"></i>{{q.date}}</p>
                    <!-- Title -->
                    <h4 class="card-title font-weight-bold mb-2">{{ q.title }}</h4>
                    <!-- Subtitle -->
                    <div class="d-flex flex-row">
                        <small class="text-danger" v-if="q.isFixed=='false'">Need Fixed</small>
                        <small class="text-success" v-if="q.isFixed=='true'"> Fixed</small>
                        <div class="d-flex flex-row">
                            <inertia-link class="ml-2 badge badge-dark" v-for="tag in q.tags" :href="'/?tag='+tag.slug"
                                          :key="tag.id">{{ tag.name }}
                            </inertia-link>
                        </div>
                    </div>
                </div>
                <div class="ml-auto mr-0" v-if="isOwn(q.user_id)">
                    <button class="btn btn-sm btn-success" v-if="q.isFixed=='false'" @click="fix(q.id,index)">Fixed
                    </button>
                    <button class="btn btn-sm btn-warning" v-if="q.isFixed=='true'" @click="unfix(q.id,index)">Unfixed
                    </button>
                    <button class="btn btn-danger btn-sm" @click="deleteQuestion(index,q.id)">Delete</button>
                </div>
            </div>

            <!-- Card body -->
            <div class="card-body pt-0">

                <div class="collapse-content">

                    <!-- Text -->
                    <p class="card-text text-dark">{{ q.description }}</p>
                    <!-- Button -->
                    <inertia-link class="btn text-success p-2 px-4" :href="route('question.detail',[q.slug,q.id])">
                        View
                    </inertia-link>
                    <small
                        class="float-right p-1 mt-3 mr-3 text-muted h5 text-warning">{{ q.comments.length }}</small>
                    <h5 style="display: inline">
                        <i class="far fa-comment float-right p-1 mt-3 h5 text-muted text-primary"></i></h5>
                    <!--like-->
                    <small class="float-right p-1 mt-3 mr-3 text-muted h5 text-warning">{{ q.like_count }}</small>
                    <h5 @click="like(q.id,index)"
                        v-show="!q.is_like" style="display: inline">
                        <i class="far fa-heart  float-right p-1 mt-3  text-danger"></i>
                    </h5>
                    <h5 @click="unlike(q.id,index)" v-show="q.is_like" style="display: inline">
                        <i class="fas fa-heart float-right p-1 mt-3 text-primary"></i>
                    </h5>
<!--                    <h5 style="display: inline">-->
                        <i class="far fa-star float-right p-1 mt-3 mr-3   text-warning"
                           @click="save(index,q.id)" v-if="q.is_save===false"></i>
                        <i class="fas fa-star float-right p-1 mt-3 mr-3   text-warning"
                           @click="unsave(index,q.id)" v-if="q.is_save===true"></i>
<!--                    </h5>-->
                </div>
            </div>
        </div>
        <Pagination class="float-right" :links="questions.links"></Pagination>
    </Master>
</template>
<script>
import Master from './Layout/Master'
import axios from 'axios'
import Pagination from "./Layout/Pagination";

export default {
    name: 'Home',
    data() {
        return {
            questions: ''
        }
    },
    components: {
        Master,
        Pagination
    },
    methods: {
        like(q_id, index) {
            axios.get('/question/like/' + q_id)
                .then(res => {
                    if (res.data.success) {
                        this.questions.data[index].is_like = true;
                        this.questions.data[index].like_count++;
                        this.$toastr.s(res.data.like);
                        this.$toastr.s('Liked');
                    }
                })
        },
        unlike(q_id, index) {
            axios.get('/question/unlike/' + q_id)
                .then(res => {
                    console.log(res.data.success);
                    if (res.data.success) {
                        this.questions.data[index].is_like = false;
                        this.questions.data[index].like_count--;
                        this.$toastr.s(res.data.unlike);
                        this.$toastr.s('Unliked');
                    }
                }).catch(err => console.log(err));
        },
        save(index,q_id) {
            axios.get(this.route('question.save', q_id))
                .then(res => {
                    if (res.data.success) {
                        this.questions.data[index].is_save = true;
                        this.$toastr.s('Saved');
                    }
                }).catch(err => console.log(err));
        },
        unsave(index,q_id) {
            axios.get(this.route('question.unsave', q_id))
                .then(res => {
                    if (res.data.success) {
                        this.questions.data[index].is_save = false;
                        this.$toastr.w('Unsaved');
                    }
                }).catch(err => console.log(err));
        },
        isOwn(user_id) {
            var auth_user = this.$page.props.auth_user.id;
            if (auth_user == user_id) {
                return true;
            }
            return false;
        },
        fix(q_id, index) {
            axios.get(this.route('question.fix', q_id))
                .then(res => {
                    if (res.data.success) {
                        this.questions.data[index].isFixed = 'true';
                    }
                })
                .catch(err => console.log(err));
        },
        unfix(q_id, index) {
            axios.get(this.route('question.unfix', q_id))
                .then(res => {
                    if (res.data.success) {
                        this.questions.data[index].isFixed = 'false';
                    }
                })
                .catch(err => console.log(err));
        },
        deleteQuestion(index, id) {
            if (confirm('Are You Sure?')) {
                axios.get(this.route('question.delete', id))
                    .then(res => {
                        if (res.data.success) {
                            this.questions.data.splice(index, 1);
                            this.$toastr.s('successfully deleted');
                        }
                    }).catch(e => this.$toastr.e('something wrong!'));
            }
        }
    },
    created() {
        this.questions = this.$page.props.questions;
        if (this.$page.props.flash.success) {
            this.$toastr.s(this.$page.props.flash.success);
        }
    }
}
</script>
