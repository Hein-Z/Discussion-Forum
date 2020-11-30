<template>
    <Master>
        <div>
            <div class="card promoting-card mb-4">

                <!-- Card content -->
                <div class="card-header d-flex flex-row " style="background-color: #4a5568">

                    <!-- Avatar -->
                    <img :src="question.user.image" class="rounded-circle mr-3"
                         height="50px" width="50px" alt="avatar">

                    <!-- Content -->
                    <div>
                        <!--  User Name-->
                        <h5 class="card-title text-success font-weight-bold h6 my-2">{{ question.user.name }}</h5>
                        <p class="card-text"><i class="far fa-clock pr-2"></i>{{ question.date }}</p>
                        <!-- Title -->
                        <h4 class="card-title font-weight-bold mb-2">{{ question.title }}</h4>
                        <!-- Subtitle -->
                        <div class="d-flex flex-row">
                            <small class="text-danger" v-if="question.isFixed=='false'">Need Fixed</small>
                            <div class="d-flex flex-row">
                                <small class="ml-2 badge badge-dark" v-for="tag in question.tags"
                                       :key="tag.id">{{ tag.name }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="ml-auto mr-0" v-if="isOwn(question.user_id)">
                        <button class="btn btn-sm btn-success" v-if="question.isFixed=='false'"
                                @click="fix(question.id)">Fixed
                        </button>
                        <button class="btn btn-sm btn-warning" v-if="question.isFixed=='true'"
                                @click="unfix(question.id)">Unfixed
                        </button>
                        <button class="btn btn-danger btn-sm" @click="deleteQuestion(question.id)">Delete</button>
                    </div>
                </div>

                <!-- Card content -->
                <div class="card-body pt-0">

                    <div class="collapse-content">

                        <!-- Text -->
                        <p class="card-text text-dark">{{ question.description }}</p>
                        <!-- Button -->
                        <small
                            class="float-right p-1 mt-3 mr-3   text-warning">{{
                                question.comments.length
                            }}</small><i
                        class="far fa-comment float-right p-1 mt-3   text-primary"></i>
                        <!--like-->
                        <small class="float-right p-1 mt-3 mr-3   text-warning">{{
                                question.like_count
                            }}</small><i
                        class="far fa-heart text-muted float-right p-1 mt-3  text-danger"
                        @click="like(question.id)"
                        v-show="!question.is_like"></i>
                        <i class="fas fa-heart float-right p-1 mt-3  text-primary"
                           @click="unlike(question.id)"
                           v-show="question.is_like"></i>
                        <i class="far fa-star float-right p-1 mt-3 mr-3   text-warning"
                           @click="save(question.id)" v-if="question.is_save===false"></i>
                        <i class="fas fa-star float-right p-1 mt-3 mr-3   text-warning"
                           @click="unsave(question.id)" v-if="question.is_save===true"></i>
                    </div>

                </div>

            </div>
            <div class="comments-list" style="max-height: 300px; overflow-y: auto" v-if="question.comments.length!==0">
                <div class="media" style=" border-bottom: 1px dotted #ccc;" v-for="c in question.comments" :key="c.id">
                    <img :src="c.user.image" class="rounded-circle mb-3 mt-1 mr-3 "
                         height="40px" width="40px" alt="avatar">
                    <div class="media-body">

                        <h5 class="media-heading font-weight-bold user_name">{{ c.user.name }}</h5>
                        {{ c.comment }}
                    </div>
                    <p class="pull-right"><small>{{ c.date }}</small></p>
                </div>
            </div>
            <form action="" @submit.prevent="createComment(question.id)">
                <div class="form-group ">
                            <textarea name="comment" class="form-control" id="comment" cols="30" rows="3"
                                      placeholder="Write your answer" v-model="comment"></textarea>
                    <button class="btn btn-success float-right btn-sm">Send</button>
                </div>
            </form>
        </div>
    </Master>
</template>
<script>
import Master from "./Layout/Master";
import axios from "axios";

export default {
    data() {
        return {
            question: null,
            comment: ''
        }
    },
    name: 'QuestionDetail',
    components: {
        Master
    },

    methods: {
        like(q_id) {
            axios.get('/question/like/' + q_id)
                .then(res => {
                    if (res.data.success) {
                        this.question.is_like = true;
                        this.question.like_count++;
                        this.$toastr.s('Liked');
                    }
                })
        },
        unlike(q_id) {
            axios.get('/question/unlike/' + q_id)
                .then(res => {
                    if (res.data.success) {
                        this.question.is_like = false;
                        this.question.like_count--;
                        this.$toastr.w('Unliked');
                    }
                }).catch(err => console.log(err));
        },
        save(q_id) {
            axios.get(this.route('question.save', q_id))
                .then(res => {
                    if (res.data.success) {
                        this.question.is_save = true;
                        this.$toastr.s('Saved');
                    }
                }).catch(err => console.log(err));
        },
        unsave(q_id) {
            axios.get(this.route('question.unsave', q_id))
                .then(res => {
                    if (res.data.success) {
                        this.question.is_save = false;
                        this.$toastr.w('Unsaved');
                    }
                }).catch(err => console.log(err));
        },
        createComment(q_id) {
            var data = new FormData();
            data.append('question_id', q_id);
            data.append('comment', this.comment);
            axios.post('/question/comment/send', data)
                .then(res => {
                    const {success, comment} = res.data;
                    if (success) {
                        this.comment = '';
                        this.question.comments.push(comment);
                    }
                })
                .catch(err => console.log(err))
        },
        isOwn(user_id) {
            var auth_user = this.$page.props.auth_user.id;
            if (auth_user == user_id) {
                return true;
            }
            return false;
        },
        fix(q_id) {
            axios.get(this.route('question.fix', q_id))
                .then(res => {
                    if (res.data.success) {
                        this.question.isFixed = 'true';
                    }
                })
                .catch(err => console.log(err));
        },
        unfix(q_id) {
            axios.get(this.route('question.unfix', q_id))
                .then(res => {
                    if (res.data.success) {
                        this.question.isFixed = 'false';
                    }
                })
                .catch(err => console.log(err));
        },
        deleteQuestion( id) {
            if (confirm('Are You Sure?')) {
                axios.get(this.route('question.delete', id))
                    .then(res => {
                        if (res.data.success) {
                            this.$toastr.s('successfully deleted');
                            window.location.href = "/";
                        }
                    }).catch(e => this.$toastr.e('something wrong!'));
            }
        }
    },
    created() {
        this.question = this.$page.props.question;
    }
}
</script>
