<input type="hidden" id="hidden_tinh" name="hidden_tinh" value="">
                            <input type="hidden" id="hidden_quan" name="hidden_quan" value="">
                            <input type="hidden" id="hidden_phuong" name="hidden_phuong" value="">
                          
                       <div>
                            <div class="col-span-1 md:col-span-4 mb-5">
                            <label for="diachi" class="mb-2 block text-sm font-medium text-gray-900"> Địa chỉ </label>
                                <input 
                                    type="text" 
                                    id="diachi" 
                                    name="diachinha" 
                                    placeholder="Nhập địa chỉ" 
                                    required 
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-200 dark:bg-gray-100  dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                />
                                <div id="diachiError" class="text-red-600 text-sm mt-1">
                                    {{ $errors->first('diachi') }}
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-3 items-center justify-center">
                            <!-- Input for address -->
                            <!-- Select for Tỉnh -->
                            <div class="col-span-1">
                                <input type="hidden" id="hidden_tinh" name="hidden_tinh" value="">
                                <label for="tinh" class="mb-2 block text-sm font-medium text-gray-900"> Tỉnh </label>
                                <select 
                                    id="tinh" 
                                    name="tinh" 
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-200 dark:bg-gray-100  dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                >
                                    <option value="">Chọn tỉnh</option>
                                    <!-- populate options with data from your database or API -->
                                </select>
                            </div>

                            <!-- Select for Quận/Huyện -->
                            <div class="col-span-1">
                                <input type="hidden" id="hidden_quan" name="hidden_quan" value="">
                                <label for="quan" class="mb-2 block text-sm font-medium text-gray-900"> Quận/Huyện </label>
                                <select 
                                    id="quan" 
                                    name="quan" 
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-200 dark:bg-gray-100  dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                >
                                    <option value="">Chọn quận/huyện</option>
                                </select>
                            </div>

                            <!-- Select for Xã/Phường -->
                            <div class="col-span-1">
                                <input type="hidden" id="hidden_phuong" name="hidden_phuong" value="">
                                <label for="phuong" class="mb-2 block text-sm font-medium text-gray-900"> Phường/Xã</label>
                                <select 
                                    id="phuong" 
                                    name="phuong" 
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-200 dark:bg-gray-100  dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                >
                                    <option value="">Chọn xã/phường</option>
                                </select>
                            </div>
                        
                        </div>
                        