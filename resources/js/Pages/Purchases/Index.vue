<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import FlashMessage from '@/Components/FlashMessage.vue';
import { ref, onMounted } from 'vue'
import { router } from '@inertiajs/vue3';
import dayjs from 'dayjs';

const props = defineProps({
  orders: Object,
  customerName: String,
  startDate: String,
  endDate: String,
})
onMounted(() => {
  console.log(props.orders.data)
})

const customerName = ref(props.customerName);

const startDate = ref(props.startDate);

const endDate = ref(props.endDate);

const searchCustomers = () => {
  router.get(route('purchases.index', {
    customerName: customerName.value,
    startDate: startDate.value,
    endDate: endDate.value
  }))
}

const makeUrl = (url) => {
  const params = {
    customerName: customerName.value ?? '',
    startDate: startDate.value ?? '',
    endDate: endDate.value ?? '',
  }
  const urlSearchParam = new URLSearchParams(params).toString();
  return url + "&" + urlSearchParam;
}
</script>

<template>
  <Head title="購買履歴一覧" />
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">購買履歴一覧</h2>
    </template>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <section class="text-gray-600 body-font">
              <div class="container px-5 py-8 mx-auto">
                <div class="flex flex-wrap -m-2">
                  <FlashMessage />
                  <div class="lg:w-2/3 w-full mx-auto">
                    <div class="flex flex-wrap -m-2">
                      <div class="p-2 w-1/2">
                        <div class="relative">
                          <label for="" class="block leading-7 text-sm text-gray-600">開始日</label>
                          <input type="date"
                            class="w-full bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                            name="startDate" v-model="startDate">
                        </div>
                      </div>
                      <div class="p-2 w-1/2">
                        <div class="relative">
                          <label for="" class="block leading-7 text-sm text-gray-600">終了日</label>
                          <input type="date"
                            class="w-full bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                            name="endDate" v-model="endDate">
                        </div>
                      </div>

                      <div class="p-2 w-1/2">
                        <div class="relative">
                          <label for="" class="block leading-7 text-sm text-gray-600">会員名</label>
                          <input
                            class="w-full rounded border appearance-none border-gray-300 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 text-base pl-3 pr-10"
                            type="text" name="search" v-model="customerName">
                        </div>
                      </div>
                    </div>
                    <button
                      class="flex ml-auto mb-3 text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded"
                      @click="searchCustomers">条件で絞り込み</button>
                    <table class="table-auto w-full text-left whitespace-no-wrap">
                      <thead>
                        <tr>
                          <th
                            class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">
                            Id</th>
                          <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                            名前</th>
                          <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                            金額</th>
                          <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                            状態</th>
                          <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                            日時</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="order in props.orders.data">
                          <td class="border-t-2 border-gray-200 px-4 py-3">
                            <Link class="text-blue-400" :href="route('purchases.show', { purchase: order.id })">{{
                              order.id
                            }}</Link>
                          </td>
                          <td class="border-t-2 border-gray-200 px-4 py-3">{{ order.customer_name }}</td>
                          <td class="border-t-2 border-gray-200 px-4 py-3">{{ Number(order.total).toLocaleString() }}</td>
                          <td class="border-t-2 border-gray-200 px-4 py-3">{{ order.status }}</td>
                          <td class="border-t-2 border-gray-200 px-4 py-3">
                            {{ dayjs(order.created_at).format('YYYY-MM-DD HH: mm: ss') }}
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div v-if="props.orders.links.length > 3">
                <div class="flex flex-wrap -mb-1">
                  <template v-for="(link, index) in props.orders.links" :key="index">
                    <div v-if="link.url === null"
                      class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded" v-html="link.label" />
                    <Link v-else
                      class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-indigo-500 focus:text-indigo-500"
                      :class="{ 'bg-blue-700 text-white': link.active }" :href="makeUrl(link.url)" v-html="link.label" />
                  </template>
                </div>
              </div>
            </section>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
