<script setup>
import Layout from '../layout.vue'
import Pagination from '../components/pagination.vue'
import { ref } from "vue";
import { Head, router,Link} from '@inertiajs/vue3'
import { watch } from "vue";
import Swal from 'sweetalert2/dist/sweetalert2.js'
import 'sweetalert2/dist/sweetalert2.min.css';

const  props = defineProps({
    products: {
        type: Object,
        default: () => ({}),
    },
    filters: {
        type: Object,
        default: () => ({}),
    },
});


let search = ref(props.filters.search);

watch(search, (value) => {
    router.get(route('dashboard.products'), { search: value  }, {preserveState: true, replace: true, });
});


const showAlert=(id) =>{
    Swal.fire({
      title: 'Are you sure?',
      text: 'You will not be able to recover this '+id,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!',
      cancelButtonText: 'No, cancel!',
    }).then((result) => {
      if (result.value) {
           destroy(id);
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        // User clicked cancel button
      }
    })
}

</script>
<template>
<Head :title="'Products'"></Head>
<Layout>
    <div class="card __web-inspector-hide-shortcut__">
        <div class="card-header">
            <Link as="button"  :href="route('dashboard.products.create')" class="btn btn-success" >Create</Link>
        </div>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th scope="col 0">
                        <h6> Search </h6>
                        <div class="col-3">
                            <input v-model="search"  type="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                        </div>
                    </th>
                </tr>
            </thead>
         </table>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                    <th>id</th>
                    <th>name</th>
                    <th>quantity</th>
                    <th>brand</th>
                    <th>model</th>
                    <th>category</th>
                    <th>stock</th>
                    <th>price</th>
                    <th>actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    <tr v-for="(product,index) in products.data">
                    <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{ product.id }}</strong></td>
                    <td>{{ product.name }}</td>
                    <td>{{ product.quantity }} </td>
                    <td>{{ product.brand }}</td>
                    <td>{{ product.model }}</td>
                    <td>{{ product.category }}</td>
                    <td>
                        <span v-if="product.stock=='instock'" class="badge bg-label-primary me-1">{{ product.stock }}</span>
                        <span v-else="product.stock=='outofstock'" class="badge bg-label-danger me-1">{{ product.stock }}</span>
                    </td>
                    <td>{{ product.price }}</td>
                    <td>
                        <div class="row ">
                            <div class="col-6">
                                <Link  as="button" :href="route('dashboard.product.edit',product.id)"  class="btn btn-warning mx-1">Edit</Link>
                                <button @click="showAlert(product.id)"  type="button" class="btn btn-danger mx-1">Delete</button>
                            </div>
                        </div>
                    </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <Pagination :lastpageCheck="products.last_page" :links="products.links" :firstPageUrl="products.first_page_url" :lastPageUrl="products.last_page_url"></Pagination>
</Layout>
</template>
