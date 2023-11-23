<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import { nl2br } from '@/common.js';

const props = defineProps({
  item: Object
})

const deleteItem = id => {
  router.delete(route('items.destroy', { item: id }), {
    onBefore: () => confirm('本当に削除しますか?')
  })
}
</script>

<template>
  <Head title="商品情報" />
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">商品情報</h2>
    </template>
    <section class="text-gray-600 body-font relative">
      <div class="container px-5 py-8 mx-auto">
        <div class="lg:w-1/2 md:w-2/3 mx-auto">
          <div class="flex flex-wrap -m-2">
            <div class="p-2 w-full">
              <div class="relative">
                <label for="name" class="leading-7 text-sm text-gray-600">商品名</label>
                <div id="name"
                  class="w-full bg-opacity-50 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                  {{ props.item.name }}</div>
              </div>
            </div>
            <div class="p-2 w-full">
              <div class="relative">
                <label for="price" class="leading-7 text-sm text-gray-600">商品価格</label>
                <div id="price"
                  class="w-full bg-opacity-50 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                  {{ props.item.price }}</div>
              </div>
            </div>
            <div class="p-2 w-full">
              <div class="relative">
                <label for="memo">メモ</label>
                <div id="memo"
                  class="w-full bg-opacity-50 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                  v-html="nl2br(props.item.memo)"></div>
              </div>
            </div>
            <div class="p-2 w-full">
              <div class="relative">
                <label for="isSelling">状態</label>
                <div id="isSelling"
                  class="w-full bg-opacity-50 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                  <span v-if="item.is_selling === 1">販売中</span>
                  <span v-if="item.is_selling === 0">停止中</span>
                </div>
              </div>
            </div>
            <div class="flex pl-4 my-4 lg:w-2/3 w-full mx-auto">
              <div class="flex justify-center">
                <Link as="button"
                  class="inline-flex text-white bg-green-500 border-0 py-2 px-6 focus:outline-none hover:bg-green-600 rounded text-lg"
                  :href="route('items.edit', { item: item.id })">編集する</Link>
                <button
                  class="ml-4 inline-flex text-white bg-red-500 border-0 py-2 px-6 focus:outline-none hover:bg-red-600 rounded text-lg"
                  @click="deleteItem(item.id)">削除する</button>
                <Link as="button"
                  class="ml-4 inline-flex text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded text-lg"
                  :href="route('items.index')">商品一覧へ</Link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </AuthenticatedLayout>
</template>
