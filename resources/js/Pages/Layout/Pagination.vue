<template>
    <nav aria-label="Page navigation example justify-content-between" v-if="links.length!==0">
        <ul class="pagination">
            <li class="page-item" v-for="(l,index) in links"
                :key="index" :class="{active:l.active,disabled:!l.url}">
                <inertia-link class="page-link" :href="l.url?l.url:'#'" v-html="l.label"></inertia-link>
            </li>
        </ul>
    </nav>
</template>
<script>
export default {
    name: 'pagination',
    props: {links: Array}
}
</script>
