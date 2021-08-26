<template>
    <div id="app">

        <div class="container py-3">
            <header>
                <div class="d-flex flex-column flex-md-row align-items-center pb-3 mb-4 border-bottom">
                    <a href="/" class="d-flex align-items-center text-dark text-decoration-none">
                        <span class="fs-4" style="font-weight: bold">RinoBot</span>
                    </a>

                    <nav class="d-inline-flex mt-2 mt-md-0 ms-md-auto">
                        <router-link class="me-3 py-2 text-dark text-decoration-none" to="/">主页</router-link>
                        <router-link class="me-3 py-2 text-dark text-decoration-none" to="/dashboard">仪表盘</router-link>
                        <router-link class="me-3 py-2 text-dark text-decoration-none" to="/setting">设置</router-link>
                    </nav>
                </div>
            </header>

            <main>

                <router-view></router-view>
            </main>
        </div>

    </div>
</template>

<style scoped>
@import "~bootstrap/dist/css/bootstrap.min.css";
html {
    font-size: 14px;
}
@media (min-width: 768px) {
    html {
        font-size: 16px;
    }
}
.pricing-header {
    max-width: 700px;
}
.card-deck .card {
    min-width: 220px;
}
.bd-placeholder-img {
    font-size: 1.125rem;
    text-anchor: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

@media (min-width: 768px) {
    .bd-placeholder-img-lg {
        font-size: 3.5rem;
    }
}
.router-link-exact-active{
    color: #8e4b90 !important;
    font-weight: bolder;
}
</style>
