<div class="overflow-hidden rounded-lg border border-gray-200 shadow-md m-5">
    <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
      <thead class="bg-gray-50">
        <tr>
          <th scope="col" class="px-6 py-4 font-medium text-gray-900"></th>
          <th scope="col" class="px-6 py-4 font-medium text-gray-900">Name</th>
          <th scope="col" class="px-6 py-4 font-medium text-gray-900">Request Date</th>
          <th scope="col" class="px-6 py-4 font-medium text-gray-900">Reason</th>
          <th scope="col" class="px-6 py-4 font-medium text-gray-900">Status</th>
          <th scope="col" class="px-6 py-4 font-medium text-gray-900"></th>
        </tr>
      </thead>
      <?php foreach ($leaveRequests as $leaveRequest): ?>
      <tbody class="divide-y divide-gray-100 border-t border-gray-100">
        <tr class="hover:bg-gray-50">
          <th class="flex gap-3 px-6 py-4 font-normal text-gray-900 items-center">
            <div class="relative h-10 w-10">
                <!-- THIS IS FROM EMPLOYEES TABLE -->
              <img
                class="h-full w-full rounded-full object-cover object-center"
                src="<?php echo $leaveRequest['image_url']; ?>"
                alt=""
              />
              <span class="absolute right-0 bottom-0 h-2 w-2 rounded-full bg-green-400 ring ring-white"></span>
            </div>
          </th>
          <td class="px-6 py-4">
            <div class="text-sm">
                <!-- THIS IS FROM EMPLOYEES TABLE -->
              <div class="font-medium text-gray-700"><?php echo $leaveRequest['first_name'] . ' ' . $leaveRequest['middle_name'] . ' ' . $leaveRequest['last_name']; ?></div>
              <div class="text-gray-400"><?php echo $leaveRequest['position']; ?></div>
            </div>
          </td>
          <td class="px-6 py-4">
            <span class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2 py-1 text-xs font-semibold text-green-600">
                <?php echo $leaveRequest['date_submitted']; ?>
            </span>
          </td>
          <!-- TYPE OF LEAVE -->
          <td class="px-6 py-4"> 
            <div class="font-medium text-gray-700"><?php echo $leaveRequest['type']; ?></div>
            <!-- DESCRIPTION/REASON: 255 max characters -->
            <div>
                <?php echo $leaveRequest['details']; ?>
            </div>
          </td>
          <td class="px-6 py-4">
            <!-- STATUS -->
            <span class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2 py-1 text-xs font-semibold text-yellow-600">
            <?php echo $leaveRequest['status']; ?>
            </span>
          </td>
          <td class="px-6 py-4">
            <div class="flex justify-end gap-4">
              <a x-data="{ tooltip: 'Accept' }" href="#">   
                <i class="ri-check-line"></i>     
              </a>
              <a x-data="{ tooltip: 'Reject' }" href="#">
                <i class="ri-close-line"></i>     
              </a>
            </div>
          </td>
        </tr>  
          <?php endforeach; ?>          
      </tbody>
    </table>
  </div>