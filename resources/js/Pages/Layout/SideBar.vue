<template>
    <div class="col-4 ">
        <!-- Card -->
        <div v-show="!isProfileUrl" class="position-fixed " style="min-width: 300px;">
            <div class="list-group">
                <inertia-link :href='route("question.create")'
                              class="list-group-item list-group-item-action bg-success">
                    Ask New Question
                </inertia-link>
                <inertia-link :href="route('home')" class="mb-0  list-group-item list-group-item-action text-center ">All
                    Tags</inertia-link>
                <inertia-link v-for="tag in $page.props.tag" :href="'/?tag='+tag.slug"
                              class="list-group-item list-group-item-action" :key="tag.id">
                    {{ tag.name }}
                </inertia-link>
            </div>
        </div>

        <!-- Card -->
        <div v-show="isProfileUrl" class="position-fixed" style="min-width: 300px;">
            <div class="list-group">
                <inertia-link :href='route("profile.edit")' class="list-group-item list-group-item-action ">
                    <i class="far fa-edit"></i>
                    Edit Profile
                </inertia-link>
                <inertia-link :href="route('user.question')" class="list-group-item list-group-item-action "><i
                    class="fas fa-question"></i>
                    Your Question
                </inertia-link>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: 'SideBar',
    computed: {
        isProfileUrl() {
            const url = location.pathname;
            var exp = '^/profile/.*';
            var res = url.match(exp);
            return res !== null;
        }
    }
}
</script>
