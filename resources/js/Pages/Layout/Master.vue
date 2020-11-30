<template>
    <div>
        <Nav></Nav>
        <div class="container">
            <!-- Card -->
            <div class="row mt-5">
                <div class="col-8">
                    <slot></slot>
                </div>
                    <SideBar></SideBar>
            </div>
        </div>
    </div>
</template>
<script>
import Nav from './Nav';
import SideBar from './SideBar';

export default {
    components: {
        Nav,
        SideBar
    }
}
</script>
