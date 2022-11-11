<template>
    <div class="panel" v-if="show">
        <div class="panel-heading">
            <span class="panel-title">Add Page</span>
        </div>
        <div class="panel-body">
            <table class="table table-link">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>{{ result }}</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="item in model.result" @click="ahmedData(item)">
                        <td class="w-1">{{ item.name }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="panel-body" method="post">
            <table class="form-table">
                <thead>
                    <tr>
                        <th>FirstName</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="w-5">
                            <input
                                type="text"
                                class="form-control"
                                v-model="form.name"
                                placeholder="Enter first name"
                            />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="panel-footer flex-end">
            <div>
                <button
                    class="btn btn-primary"
                    :disabled="isProcessing"
                    @click="onSave"
                >
                    Save
                </button>
                <button class="btn" :disabled="isProcessing" @click="onCancel">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
import Vue from "vue";
import { get, byMethod } from "../../lib/api";

function initialize(to) {
    let urls = {
        create: `/api/page/create`,
        // edit: `/api/page/${to.params.id}/edit`,
    };

    return urls[to.meta.mode] || urls["create"];
}
export default {
    data() {
        return {
            model: {
                data: [],
            },
            form: {},
            errors: {},
            isProcessing: false,
            show: false,
            resource: "",
            store: "/api/page",
            method: "POST",
            title: "Create",
            pageURL: "/api/page",
        };
    },
    beforeRouteEnter(to, from, next) {
        get(initialize(to)).then((res) => {
            next((vm) => vm.setData(res));
        });
    },
    beforeRouteUpdate(to, from, next) {
        this.show = false;
        get(initialize(to)).then((res) => {
            this.setData(res);
            next();
        });
    },
    created() {},
    methods: {
        reloadPage() {
            window.location.reload();
        },
        showNames() {
            get("/showNames");
        },
        // detailsPage(item) {
        //     console.log(item);
        //     get("/api/page/edit");
        //     // get(`api/page/${item.id}`).then((res) => {
        //     //     Vue.set(this.$data, "model", res.data);
        //     // });
        //     // // console.log(res);
        //     // // console.log(res.data);
        //     // // console.log(item.ids);
        //     // // this.$router.push(`/page/${item.id}/edit`);
        //     // // window.location.reload();
        //     // // Vue.set(this.data, "model", item.name);
        // },

        ahmedData(item) {
            // get(`api/page/${item.id}`).then((res) => {
            //     Vue.set(this.$data, "model", res.data);
            // });
            byMethod("get", `api/page/${item.id}`).then((res) => {
                Vue.set(this.$data.form, "ahmed", res.data.model.name);
                console.log(res.data.model);
            });
        },
        setData(res) {
            // console.log(res.data.result)
            Vue.set(this.$data, "form", res.data);
            Vue.set(this.$data, "model", res.data);

            this.$bar.finish();
            console.log(res);

            if (this.$route.meta.mode === "edit") {
                this.store = `/api/page/${this.$route.params.id}`;
                this.method = "PUT";
                this.title = "Edit";
            }

            this.show = true;
            this.$bar.finish();
        },
        addNewLine() {
            this.form.pgs.push({
                name: null,
            });
        },
        removeItem(index) {
            this.form.splice(index, 1);
        },
        onCancel() {
            if (this.$route.meta.mode === "edit") {
                this.$router.push(`${this.resource}`);
            } else {
                this.$router.push(`${this.resource}`);
            }
        },
        onEdit() {
            // this.errors = {};
            // this.isProcessing = true;
            // byMethod(this.method, this.store, this.form)
            //     .then((res) => {
            //         if (res.data && res.data.saved) {
            //             // console.log(res);
            //             this.$router.push(`${this.resource}`);
            //             // this.success(res)
            //         }
            //     })
            //     .catch((error) => {
            //         if (error.response.status === 422) {
            //             this.errors = error.response.data.errors;
            //         }
            //         this.isProcessing = false;
            //     });
        },
        onSave() {
            this.errors = {};
            this.isProcessing = true;
            byMethod(this.method, this.store, this.form).then((res) => {
                if (res.data && res.data.saved) {
                    // console.log(res);
                    this.$router.push(`${this.resource}`);
                    // this.success(res)
                    window.location.reload();
                }
            });
            // .catch((error) => {
            //     if (error.response.status === 422) {
            //         this.errors = error.response.data.errors;
            //     }
            //     this.isProcessing = false;
            // });
            // this.created();
        },
        success(res) {
            this.$router.push(`${this.resource}/${res.data.id}`);
        },
    },
};
</script>
