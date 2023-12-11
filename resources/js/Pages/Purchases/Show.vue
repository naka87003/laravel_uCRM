<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import dayjs from 'dayjs';
import { onMounted } from 'vue'

const props = defineProps({
  items: Object,
  order: Object,
});

onMounted(() => {
  console.log(props.items);
  console.log(typeof props.order[0].status);
});
</script>

<template>
  <Head title="購買履歴詳細" />
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">購買履歴詳細</h2>
    </template>
    <section class="text-gray-600 body-font relative">
      <div class="container px-5 py-8 mx-auto">
        <div class="lg:w-1/2 md:w-2/3 mx-auto">
          <div class="flex flex-wrap -m-2">
            <div class="p-2 w-1/2">
              <div class="relative">
                <label for="name" class="block leading-7 text-sm text-gray-600">会員名</label>
                <div id="name"
                  class="w-full bg-opacity-50 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                  {{ props.order[0].customer_name }}</div>
              </div>
            </div>
            <div class="p-2 w-1/2">
              <div>
                <label for="date" class="block leading-7 text-sm text-gray-600">日付</label>
                <div id="date"
                  class="w-full bg-opacity-50 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                  {{ dayjs(props.order[0].created_at).format('YYYY/MM/DD') }}</div>
              </div>
            </div>
            <div class="p-2 w-full">
              <div>
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
                    <tr v-for="item in props.items" :key="item.id">
                      <td class="border-t-2 border-gray-200 px-4 py-3">{{ item.item_id }}</td>
                      <td class="border-t-2 border-gray-200 px-4 py-3">{{ item.item_name }}</td>
                      <td class="border-t-2 border-gray-200 px-4 py-3">{{ item.item_price?.toLocaleString() }}</td>
                      <td class="border-t-2 border-gray-200 px-4 py-3">{{ item.quantity }}</td>
                      <td class="border-t-2 border-gray-200 px-4 py-3">{{ item.subtotal?.toLocaleString() }}</td>
                    </tr>
                  </tbody>
                </table>
                <div class="p-2 w-1/2">
                  <div class="relative">
                    <label for="total" class="block leading-7 text-sm text-gray-600">合計金額</label>
                    <div id="total"
                      class="w-full bg-opacity-50 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                      {{ Number(props.order[0].total).toLocaleString() }} 円</div>
                  </div>
                </div>
                <div class="p-2 w-1/2">
                  <div>
                    <label for="total" class="block leading-7 text-sm text-gray-600">ステータス</label>
                    <div v-if="props.order[0].status === 1" id="total"
                      class="w-full bg-opacity-50 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                      未キャンセル</div>
                    <div v-if="props.order[0].status === 0" id="total"
                      class="w-full bg-opacity-50 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                      キャンセル済み</div>
                  </div>
                </div>
                <div v-if="props.order[0].status === 0" class="p-2 w-1/2">
                  <div class="relative">
                    <label for="total" class="block leading-7 text-sm text-gray-600">キャンセル日</label>
                    <div id="total"
                      class="w-full bg-opacity-50 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                      {{ dayjs(props.order[0].updated_at).format('YYYY/MM/DD') }}</div>
                  </div>
                </div>
              </div>
            </div>
            <div class="flex pl-4 my-4 lg:w-2/3 w-full mx-auto">
              <div class="flex justify-center">
                <div v-if="props.order[0].status == true">
                  <Link as="button"
                    class="inline-flex text-white bg-green-500 border-0 py-2 px-6 focus:outline-none hover:bg-green-600 rounded text-lg"
                    :href="route('purchases.edit', { purchase: props.order[0].id })">編集する</Link>
                </div>
                <Link as="button"
                  class="ml-4 inline-flex text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded text-lg"
                  :href="route('purchases.index')">購買履歴一覧へ</Link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </AuthenticatedLayout>
</template >
