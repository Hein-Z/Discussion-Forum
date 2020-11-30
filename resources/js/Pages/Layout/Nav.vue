<template>
    <!--Navbar -->
    <nav class="mb-1 navbar navbar-expand-lg navbar-dark sticky-top default-color">
        <inertia-link class="navbar-brand" href="/">Discussion</inertia-link>
        <button class="navbar-toggler" type="button" data-toggle="collapse"
                data-target="#navbarSupportedContent-333"
                aria-controls="navbarSupportedContent-333" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent-333">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <inertia-link class="nav-link" :href="route('home')">All Question
                        <span class="sr-only">(current)</span>
                    </inertia-link>
                </li>
                <li class="nav-item">
                    <inertia-link class="nav-link" href="/?type=answered">Answered Question</inertia-link>
                </li>
                <li class="nav-item">
                    <inertia-link class="nav-link" href="/?type=unanswered">Unanswered Question</inertia-link>
                </li>
                <li class="nav-item">
                    <inertia-link class="nav-link" href="/?type=saved">Saved Question</inertia-link>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto nav-flex-icons">
                <li class="nav-item">
                    <a class="nav-link waves-effect waves-light">
                        <i class="fab fa-twitter"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link waves-effect waves-light">
                        <i class="fab fa-google-plus-g"></i>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-default"
                         aria-labelledby="navbarDropdownMenuLink-333">
                        <inertia-link class="dropdown-item" :href="route('user.question')">Welcome
                            {{ $page.props.auth_user.name }}
                        </inertia-link>
                        <inertia-link class="dropdown-item" href="/profile/edit">Edit Profile</inertia-link>
                        <inertia-link class="dropdown-item" :href="route('logout')">Logout</inertia-link>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <!--/.Navbar -->
</template>
<script>
export default {
    name: 'nav'
}
</script>
