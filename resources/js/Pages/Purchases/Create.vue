<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { getToday } from '@/common' // 別ファイルをインポート
import { ref, onMounted, computed } from 'vue'
import { router } from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue';
import MicorModal from '@/Components/MicroModal.vue';

const props = defineProps({
  errors: Object,
  customers: Object,
  items: Object,
});

const form = ref({
  date: null,
  customer_id: null,
  status: true,
  items: []
});

const itemList = ref([]);

const quantity = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"]; // option用

onMounted(() => { // ページ読み込み後 即座に実行
  form.value.date = getToday();
  props.items.forEach(item => { // 配列を1つずつ処理
    itemList.value.push({ // 配列に1つずつ追加
      id: item.id,
      name: item.name,
      price: item.price,
      quantity: 0
    })
  });
});

const totalPrice = computed(() => {
  let total = 0;
  itemList.value.forEach(item => {
    total += item.price * item.quantity;
  })
  return total;
});

const storePurchase = () => {
  itemList.value.forEach(item => {
    if (item.quantity > 0) // 0より大きいものだけ追加
      form.value.items.push({ id: item.id, quantity: item.quantity });
  })
  router.post(route('purchases.store'), form.value);
}

const setCustomerId = id => {
  form.value.customer_id = id;
};
</script>

<template>
  <Head title="購入画面" />
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">購入画面</h2>
    </template>
    <section class="text-gray-600 body-font relative">
      <form @submit.prevent="storePurchase">
        <div class="container px-5 py-8 mx-auto">
          <div class="lg:w-1/2 md:w-2/3 mx-auto">
            <div class="flex flex-wrap -m-2">
              <div class="p-2 w-1/2">
                <div class="relative">
                  <label for="" class="block leading-7 text-sm text-gray-600">会員名</label>
                  <select name="customer" v-model="form.customer_id" id="customer"
                    class="w-full rounded border appearance-none border-gray-300 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 text-base pl-3 pr-10">
                    <option v-for="customer in props.customers" :value="customer.id" :key="customer.id">
                      {{ customer.id }} : {{ customer.name }}
                    </option>
                  </select>
                  <InputError :message="props.errors.customer_id" />
                </div>
              </div>
              <div class="p-2 w-1/2">
                <div class="relative">
                  <label for="customer" class="block leading-7 text-sm text-gray-600">会員検索</label>
                  <MicorModal @update:customerId="setCustomerId" />
                </div>
              </div>
              <div class="p-2 w-1/2">
                <div class="">
                  <label for="name" class="block leading-7 text-sm text-gray-600">日付</label>
                  <input type="date" v-model="form.date" id="date" name="date"
                    class="w-full bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                  <InputError :message="props.errors.date" />
                </div>
              </div>
              <div class="p-2 w-full">
                <div class="">
                  <label class="block leading-7 text-sm text-gray-600">商品・サービス</label>
                  <table class="table-auto w-full text-left whitespace-no-wrap">
                    <thead>
                      <tr>
                        <th
                          class="px-4 py-3 bg-gray-100 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">
                          Id</th>
                        <th
                          class="px-4 py-3 bg-gray-100 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                          商品名
                        </th>
                        <th
                          class="px-4 py-3 bg-gray-100 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                          価格</th>
                        <th
                          class="px-4 py-3 bg-gray-100 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                          数量
                        </th>
                        <th
                          class="w-10 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tr rounded-br">
                          小計
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="item in itemList">
                        <td class="border-t-2 border-gray-200 px-4 py-3">{{ item.id }}</td>
                        <td class="border-t-2 border-gray-200 px-4 py-3">{{ item.name }}</td>
                        <td class="border-t-2 border-gray-200 px-4 py-3">{{ item.price }}</td>
                        <td class="border-t-2 border-gray-200 px-4 py-3">
                          <select name="quantity" v-model="item.quantity">
                            <option v-for="q in quantity" :value="q">{{ q }}</option>
                          </select>
                        </td>
                        <td>
                          {{ item.price * item.quantity }}
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <div class="text-right">
                    合計 {{ totalPrice }} 円
                  </div>
                </div>
              </div>
              <div class="p-2 w-full">
                <button
                  class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">登録する</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </section>
  </AuthenticatedLayout>
</template>
