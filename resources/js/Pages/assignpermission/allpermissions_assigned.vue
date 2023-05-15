<script setup>
import Layout from '../layout.vue'
import { router } from '@inertiajs/core';
import { Head,Link } from '@inertiajs/vue3';
import Swal from 'sweetalert2/dist/sweetalert2.js'
import 'sweetalert2/dist/sweetalert2.min.css';

const  props = defineProps({
    assignedPermissions:{
        type:Array,
        default: () => ([]),
    },
    role:{
        type:Object,
        default: () => ({}),
    }
});
 
const { roleid }=props.role.id

const rollback = (id) => {
    const role=roleid;
    const permission=id;
    router.delete(route('dashboard.assignpermission.rollback',[role,permission]));
}

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
         rollback(id);
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        // User clicked cancel button
      }
    })
}
</script>
<template>
    <Head :title="'All Permissions Assigned'"></Head>
    <Layout>
        <div class="card __web-inspector-hide-shortcut__">
        <div class="card-header">
            <h5 class="float-end"><Link :href="route('dashboard.assignpermission')">Back</Link></h5>
            <h5 class="mb-0">{{ role.name }}</h5>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                    <th>id</th>
                    <th>name</th>
                    <th>guard</th>
                    <th>created_at</th>
                    <th>updated_at</th>
                    <th>actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    <tr v-for="(permission,index) in assignedPermissions">
                    <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{ permission.id }}</strong></td>
                    <td>{{ permission.name }}</td>
                    <td>{{ permission.guard_name }} </td>
                    <td>{{ permission.created_at }}</td>
                    <td >{{ permission.updated_at }}</td>
                    <td><button @click="showAlert(permission.id)" class="btn btn-danger">Revoke</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
        </div>
    </Layout>
</template>