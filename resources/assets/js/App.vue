<template>
    <div class="container">
        <div class="navbar">&nbsp;</div>
        <div class="content">
            <li>
                <button
                    class="font-bold tracking-tight block cursor-pointer p-2 hover:text-cyan-400 transition-colors duration-300"
                    @click="logout"
                >
                    LOGOUT
                    <span class="text-2xl"><i class="bx bx-user"></i></span>
                </button>
            </li>
            <transition name="fade" mode="out-in">
                <router-view class="page" :key="$route.path"></router-view>
            </transition>
        </div>
    </div>
</template>
<script type="text/javascript">
import { byMethod } from "./lib/api";
export default {
    methods: {
        logout() {
            console.log("in");
            byMethod("post", "/logout", "").then((res) => {
                if (res.data.success) {
                    window.location = "/login";
                }
            });
        },
    },
};
</script>
