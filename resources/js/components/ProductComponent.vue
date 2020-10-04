<template>
    <div class="container my-5">
        <!-- Create -->
        <div class="row justify-content-end mb-3">
            <div class="col-4">
                <button class="btn btn-primary" @click="create">
                    <i class="fas fa-plus-circle mr-1"></i> Create
                </button>
            </div>
            <div class="col-4">
                <form @submit.prevent="view">
                    <div class="input-group">
                        <input
                            v-model="search"
                            type="text"
                            placeholder="Search"
                            class="form-control"
                        />
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Create End -->

        <!-- Table -->
        <div class="row">
            <div class="col-4">
                <div class="card">
                    <h4 class="card-header">
                        {{ isEditMode ? "Edit" : "Create" }}
                    </h4>
                    <div class="card-body">
                        <alert-error
                            :form="product"
                            :message="message"
                        ></alert-error>

                        <form @submit.prevent="isEditMode ? update() : store()">
                            <div class="form-group">
                                <label>Name: </label>
                                <input
                                    v-model="product.name"
                                    type="text"
                                    class="form-control"
                                    :class="{
                                        'is-invalid': product.errors.has('name')
                                    }"
                                />
                                <has-error
                                    :form="product"
                                    field="name"
                                ></has-error>
                            </div>
                            <div class="form-group">
                                <label>Price: </label>
                                <input
                                    v-model="product.price"
                                    type="number"
                                    class="form-control"
                                    :class="{
                                        'is-invalid': product.errors.has('name')
                                    }"
                                />
                                <has-error
                                    :form="product"
                                    field="price"
                                ></has-error>
                            </div>
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-save mr-1"></i> Save
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="product in products.data" :key="product.id">
                            <td>{{ product.id }}</td>
                            <td>{{ product.name }}</td>
                            <td>{{ product.price }}</td>
                            <td>
                                <button
                                    class="btn btn-success btn-sm"
                                    @click="edit(product)"
                                >
                                    <i class="fas fa-edit mr-1"></i> Edit
                                </button>
                                <button
                                    class="btn btn-danger btn-sm"
                                    @click="destroy(product.id)"
                                >
                                    <i class="fas fa-trash-alt mr-1"></i> Delete
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <pagination
                    :data="products"
                    @pagination-change-page="view"
                ></pagination>
            </div>
        </div>
        <!-- Table End-->
    </div>
</template>

<script>
export default {
    name: "ProductComponent",
    data() {
        return {
            isEditMode: false,
            search: "",
            products: {},
            product: new Form({
                id: "",
                name: "",
                price: ""
            }),
            message: ""
        };
    },
    methods: {
        view(page = 1) {
            this.$Progress.start();
            let loader = this.$loading.show();

            axios
                .get(`/api/product?page=${page}&search=${this.search}`)
                .then(response => {
                    this.products = response.data;
                    this.$Progress.finish();
                    loader.hide();
                })
                .catch(error => {
                    this.$Progress.fail();
                    loader.hide();
                });
        },
        create() {
            this.product.clear();
            this.isEditMode = false;
            this.product.reset();
        },
        store() {
            this.product
                .post("/api/product")
                .then(response => {
                    this.view();
                    this.product.reset();
                    Toast.fire({
                        icon: "success",
                        title: "Created successfully"
                    });
                })
                .catch(error => {
                    this.message = error.response.data.message;
                });
        },
        edit(product) {
            this.product.clear();
            this.isEditMode = true;
            this.product.fill(product);
        },
        update() {
            this.product
                .put(`/api/product/${this.product.id}`)
                .then(response => {
                    this.view();
                    this.product.reset();
                    Toast.fire({
                        icon: "success",
                        title: "Deleted successfully"
                    });
                });
        },
        destroy(id) {
            Swal.fire({
                title: "Are you sure?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Delete"
            }).then(result => {
                if (result.isConfirmed) {
                    axios.delete(`/api/product/${id}`).then(response => {
                        this.view();
                        Swal.fire({ title: "Deleted!", icon: "success" });
                        Toast.fire({
                            icon: "success",
                            title: "Deleted successfully"
                        });
                    });
                }
            });
        }
    },
    created() {
        this.view();
    }
};
</script>
