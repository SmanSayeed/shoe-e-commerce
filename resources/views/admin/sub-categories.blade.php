<x-admin-layout>
         <!-- Page Title Starts -->
            <div class="mb-6 flex flex-col justify-between gap-y-1 sm:flex-row sm:gap-y-0">
              <h5>Subcategories List</h5>

              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="/">Home</a>
                </li>
                <li class="breadcrumb-item">
                  <a href="#">Categories</a>
                </li>
                <li class="breadcrumb-item">
                  <a href="#">Subcategories List</a>
                </li>
              </ol>
            </div>
            <!-- Page Title Ends -->

            <!-- Subcategories List Starts -->
            <div class="space-y-4">
              <!-- Subcategory Header Starts -->
              <div class="flex flex-col items-center justify-between gap-y-4 md:flex-row md:gap-y-0">
                <!-- Subcategory Search Starts -->
                <form
                  class="group flex h-10 w-full items-center rounded-primary border border-transparent bg-white shadow-sm focus-within:border-primary-500 focus-within:ring-1 focus-within:ring-inset focus-within:ring-primary-500 dark:border-transparent dark:bg-slate-800 dark:focus-within:border-primary-500 md:w-72"
                >
                  <div class="flex h-full items-center px-2">
                    <i class="h-4 text-slate-400 group-focus-within:text-primary-500" data-feather="search"></i>
                  </div>
                  <input
                    class="h-full w-full border-transparent bg-transparent px-0 text-sm placeholder-slate-400 placeholder:text-sm focus:border-transparent focus:outline-none focus:ring-0"
                    type="text"
                    placeholder="Search subcategories"
                  />
                </form>
                <!-- Subcategory Search Ends -->

                <!-- Subcategory Action Starts -->
                <div class="flex w-full items-center justify-between gap-x-4 md:w-auto">
                  <div class="flex items-center gap-x-4">
                    <div class="dropdown" data-placement="bottom-end">
                      <div class="dropdown-toggle">
                        <button type="button" class="btn bg-white font-medium shadow-sm dark:bg-slate-800">
                          <i class="w-4" data-feather="filter"></i>
                          <span class="hidden sm:inline-block">Filter</span>
                          <i class="w-4" data-feather="chevron-down"></i>
                        </button>
                      </div>
                      <div class="dropdown-content w-72 !overflow-visible">
                        <ul class="dropdown-list space-y-4 p-4">
                          <li class="dropdown-list-item">
                            <h2 class="my-1 text-sm font-medium">Category</h2>
                            <select class="tom-select w-full" autocomplete="off">
                              <option value="">Select Category</option>
                              <option value="1">Sneakers</option>
                              <option value="2">Boots</option>
                              <option value="3">Sandals</option>
                              <option value="4">Formal Shoes</option>
                            </select>
                          </li>
                          <li class="dropdown-list-item">
                            <h2 class="my-1 text-sm font-medium">Status</h2>
                            <select class="tom-select w-full" autocomplete="off">
                              <option value="">Select Status</option>
                              <option value="1">Active</option>
                              <option value="2">Inactive</option>
                            </select>
                          </li>
                        </ul>
                      </div>
                    </div>
                    <button class="btn bg-white font-medium shadow-sm dark:bg-slate-800">
                      <i class="h-4" data-feather="upload"></i>
                      <span class="hidden sm:inline-block">Export</span>
                    </button>
                  </div>

                  <a class="btn btn-primary" href="#" role="button">
                    <i data-feather="plus" height="1rem" width="1rem"></i>
                    <span class="hidden sm:inline-block">Add Subcategory</span>
                  </a>
                </div>
                <!-- Subcategory Action Ends -->
              </div>
              <!-- Subcategory Header Ends -->

              <!-- Subcategory Table Starts -->
              <div class="table-responsive whitespace-nowrap rounded-primary">
                <table class="table">
                  <thead>
                    <tr>
                      <th class="w-[5%]">
                        <input class="checkbox" type="checkbox" data-check-all data-check-all-target=".subcategory-checkbox" />
                      </th>
                      <th class="w-[20%] uppercase">Subcategory</th>
                      <th class="w-[20%] uppercase">Category</th>
                      <th class="w-[30%] uppercase">Description</th>
                      <th class="w-[10%] uppercase">Status</th>
                      <th class="w-[10%] uppercase">Created Date</th>
                      <th class="w-[5%] !text-right uppercase">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                        <input class="checkbox subcategory-checkbox" type="checkbox" />
                      </td>
                      <td>
                        <div class="flex items-center gap-3">
                          <div class="avatar avatar-circle">
                            <img class="avatar-img" src="{{ asset('images/subcategories/running-sneakers.jpg') }}" alt="Running Sneakers" />
                          </div>
                          <div>
                            <h6 class="whitespace-nowrap text-sm font-medium text-slate-700 dark:text-slate-100">
                              Running Sneakers
                            </h6>
                            <p class="truncate text-xs text-slate-500 dark:text-slate-400">running-sneakers</p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <span class="badge badge-soft-primary">Sneakers</span>
                      </td>
                      <td>
                        <p class="truncate text-sm text-slate-600 dark:text-slate-300">
                          High-performance athletic shoes designed for running and jogging activities.
                        </p>
                      </td>
                      <td>
                        <div class="badge badge-soft-success">Active</div>
                      </td>
                      <td>15 Oct 2024</td>
                      <td>
                        <div class="flex justify-end">
                          <div class="dropdown" data-placement="bottom-start">
                            <div class="dropdown-toggle">
                              <i class="w-6 text-slate-400" data-feather="more-horizontal"></i>
                            </div>
                            <div class="dropdown-content">
                              <ul class="dropdown-list">
                                <li class="dropdown-list-item">
                                  <a href="javascript:void(0)" class="dropdown-link">
                                    <i class="h-5 text-slate-400" data-feather="external-link"></i>
                                    <span>Details</span>
                                  </a>
                                </li>
                                <li class="dropdown-list-item">
                                  <a href="javascript:void(0)" class="dropdown-link">
                                    <i class="h-5 text-slate-400" data-feather="edit"></i>
                                    <span>Edit</span>
                                  </a>
                                </li>
                                <li class="dropdown-list-item">
                                  <a href="javascript:void(0)" class="dropdown-link">
                                    <i class="h-5 text-slate-400" data-feather="trash"></i>
                                    <span>Delete</span>
                                  </a>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <input class="checkbox subcategory-checkbox" type="checkbox" />
                      </td>
                      <td>
                        <div class="flex items-center gap-3">
                          <div class="avatar avatar-circle">
                            <img class="avatar-img" src="{{ asset('images/subcategories/casual-sneakers.jpg') }}" alt="Casual Sneakers" />
                          </div>
                          <div>
                            <h6 class="whitespace-nowrap text-sm font-medium text-slate-700 dark:text-slate-100">
                              Casual Sneakers
                            </h6>
                            <p class="truncate text-xs text-slate-500 dark:text-slate-400">casual-sneakers</p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <span class="badge badge-soft-primary">Sneakers</span>
                      </td>
                      <td>
                        <p class="truncate text-sm text-slate-600 dark:text-slate-300">
                          Comfortable everyday sneakers perfect for casual wear and light activities.
                        </p>
                      </td>
                      <td>
                        <div class="badge badge-soft-success">Active</div>
                      </td>
                      <td>12 Oct 2024</td>
                      <td>
                        <div class="flex justify-end">
                          <div class="dropdown" data-placement="bottom-start">
                            <div class="dropdown-toggle">
                              <i class="w-6 text-slate-400" data-feather="more-horizontal"></i>
                            </div>
                            <div class="dropdown-content">
                              <ul class="dropdown-list">
                                <li class="dropdown-list-item">
                                  <a href="javascript:void(0)" class="dropdown-link">
                                    <i class="h-5 text-slate-400" data-feather="external-link"></i>
                                    <span>Details</span>
                                  </a>
                                </li>
                                <li class="dropdown-list-item">
                                  <a href="javascript:void(0)" class="dropdown-link">
                                    <i class="h-5 text-slate-400" data-feather="edit"></i>
                                    <span>Edit</span>
                                  </a>
                                </li>
                                <li class="dropdown-list-item">
                                  <a href="javascript:void(0)" class="dropdown-link">
                                    <i class="h-5 text-slate-400" data-feather="trash"></i>
                                    <span>Delete</span>
                                  </a>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <input class="checkbox subcategory-checkbox" type="checkbox" />
                      </td>
                      <td>
                        <div class="flex items-center gap-3">
                          <div class="avatar avatar-circle">
                            <img class="avatar-img" src="{{ asset('images/subcategories/hiking-boots.jpg') }}" alt="Hiking Boots" />
                          </div>
                          <div>
                            <h6 class="whitespace-nowrap text-sm font-medium text-slate-700 dark:text-slate-100">
                              Hiking Boots
                            </h6>
                            <p class="truncate text-xs text-slate-500 dark:text-slate-400">hiking-boots</p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <span class="badge badge-soft-primary">Boots</span>
                      </td>
                      <td>
                        <p class="truncate text-sm text-slate-600 dark:text-slate-300">
                          Durable boots designed for hiking and outdoor activities with excellent grip and support.
                        </p>
                      </td>
                      <td>
                        <div class="badge badge-soft-success">Active</div>
                      </td>
                      <td>08 Oct 2024</td>
                      <td>
                        <div class="flex justify-end">
                          <div class="dropdown" data-placement="bottom-start">
                            <div class="dropdown-toggle">
                              <i class="w-6 text-slate-400" data-feather="more-horizontal"></i>
                            </div>
                            <div class="dropdown-content">
                              <ul class="dropdown-list">
                                <li class="dropdown-list-item">
                                  <a href="javascript:void(0)" class="dropdown-link">
                                    <i class="h-5 text-slate-400" data-feather="external-link"></i>
                                    <span>Details</span>
                                  </a>
                                </li>
                                <li class="dropdown-list-item">
                                  <a href="javascript:void(0)" class="dropdown-link">
                                    <i class="h-5 text-slate-400" data-feather="edit"></i>
                                    <span>Edit</span>
                                  </a>
                                </li>
                                <li class="dropdown-list-item">
                                  <a href="javascript:void(0)" class="dropdown-link">
                                    <i class="h-5 text-slate-400" data-feather="trash"></i>
                                    <span>Delete</span>
                                  </a>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <input class="checkbox subcategory-checkbox" type="checkbox" />
                      </td>
                      <td>
                        <div class="flex items-center gap-3">
                          <div class="avatar avatar-circle">
                            <img class="avatar-img" src="{{ asset('images/subcategories/dress-boots.jpg') }}" alt="Dress Boots" />
                          </div>
                          <div>
                            <h6 class="whitespace-nowrap text-sm font-medium text-slate-700 dark:text-slate-100">
                              Dress Boots
                            </h6>
                            <p class="truncate text-xs text-slate-500 dark:text-slate-400">dress-boots</p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <span class="badge badge-soft-primary">Boots</span>
                      </td>
                      <td>
                        <p class="truncate text-sm text-slate-600 dark:text-slate-300">
                          Elegant leather boots suitable for formal occasions and business attire.
                        </p>
                      </td>
                      <td>
                        <div class="badge badge-soft-danger">Inactive</div>
                      </td>
                      <td>05 Oct 2024</td>
                      <td>
                        <div class="flex justify-end">
                          <div class="dropdown" data-placement="bottom-start">
                            <div class="dropdown-toggle">
                              <i class="w-6 text-slate-400" data-feather="more-horizontal"></i>
                            </div>
                            <div class="dropdown-content">
                              <ul class="dropdown-list">
                                <li class="dropdown-list-item">
                                  <a href="javascript:void(0)" class="dropdown-link">
                                    <i class="h-5 text-slate-400" data-feather="external-link"></i>
                                    <span>Details</span>
                                  </a>
                                </li>
                                <li class="dropdown-list-item">
                                  <a href="javascript:void(0)" class="dropdown-link">
                                    <i class="h-5 text-slate-400" data-feather="edit"></i>
                                    <span>Edit</span>
                                  </a>
                                </li>
                                <li class="dropdown-list-item">
                                  <a href="javascript:void(0)" class="dropdown-link">
                                    <i class="h-5 text-slate-400" data-feather="trash"></i>
                                    <span>Delete</span>
                                  </a>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <input class="checkbox subcategory-checkbox" type="checkbox" />
                      </td>
                      <td>
                        <div class="flex items-center gap-3">
                          <div class="avatar avatar-circle">
                            <img class="avatar-img" src="{{ asset('images/subcategories/oxford-shoes.jpg') }}" alt="Oxford Shoes" />
                          </div>
                          <div>
                            <h6 class="whitespace-nowrap text-sm font-medium text-slate-700 dark:text-slate-100">
                              Oxford Shoes
                            </h6>
                            <p class="truncate text-xs text-slate-500 dark:text-slate-400">oxford-shoes</p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <span class="badge badge-soft-primary">Formal Shoes</span>
                      </td>
                      <td>
                        <p class="truncate text-sm text-slate-600 dark:text-slate-300">
                          Classic lace-up dress shoes characterized by their closed lacing system.
                        </p>
                      </td>
                      <td>
                        <div class="badge badge-soft-success">Active</div>
                      </td>
                      <td>03 Oct 2024</td>
                      <td>
                        <div class="flex justify-end">
                          <div class="dropdown" data-placement="bottom-start">
                            <div class="dropdown-toggle">
                              <i class="w-6 text-slate-400" data-feather="more-horizontal"></i>
                            </div>
                            <div class="dropdown-content">
                              <ul class="dropdown-list">
                                <li class="dropdown-list-item">
                                  <a href="javascript:void(0)" class="dropdown-link">
                                    <i class="h-5 text-slate-400" data-feather="external-link"></i>
                                    <span>Details</span>
                                  </a>
                                </li>
                                <li class="dropdown-list-item">
                                  <a href="javascript:void(0)" class="dropdown-link">
                                    <i class="h-5 text-slate-400" data-feather="edit"></i>
                                    <span>Edit</span>
                                  </a>
                                </li>
                                <li class="dropdown-list-item">
                                  <a href="javascript:void(0)" class="dropdown-link">
                                    <i class="h-5 text-slate-400" data-feather="trash"></i>
                                    <span>Delete</span>
                                  </a>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- Subcategory Table Ends -->

              <!-- Subcategory Pagination Starts -->
              <div class="flex flex-col items-center justify-between gap-y-4 md:flex-row">
                <p class="text-xs font-normal text-slate-400">Showing 1 to 5 of 18 subcategories</p>
                <!-- Pagination -->
                <nav class="pagination">
                  <ul class="pagination-list">
                    <li class="pagination-item">
                      <a class="pagination-link pagination-link-prev-icon" href="#">
                        <i data-feather="chevron-left" width="1em" height="1em"></i>
                      </a>
                    </li>
                    <li class="pagination-item active">
                      <a class="pagination-link" href="#">1</a>
                    </li>
                    <li class="pagination-item">
                      <a class="pagination-link" href="#">2</a>
                    </li>
                    <li class="pagination-item">
                      <a class="pagination-link" href="#">3</a>
                    </li>
                    <li class="pagination-item">
                      <a class="pagination-link" href="#">4</a>
                    </li>
                    <li class="pagination-item">
                      <a class="pagination-link pagination-link-next-icon" href="#">
                        <i data-feather="chevron-right" width="1em" height="1em"></i>
                      </a>
                    </li>
                  </ul>
                </nav>
              </div>
              <!-- Subcategory Pagination Ends -->
            </div>
            <!-- Subcategories List Ends -->
</x-admin-layout>