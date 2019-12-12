



<div class="page-header card">

   <div class="card-block">

      <h5 class="m-b-10"><?=$title?></h5>

      <ul class="breadcrumb-title b-t-default p-t-10">

         <li class="breadcrumb-item" style="line-height: 2.5">

            <a href="<?=base_url('admin_panel/dashboard')?>">الرئيسية</a>

         </li>

         <li class="breadcrumb-item"><a href="<?=base_url('admin_panel/categories')?>" style="line-height: 2.5"><?=$title?></a>

         </li>
         <a style="float: left; color: white" href="<?=base_url('admin_panel/products/add')?>" class="btn btn-grd-primary">اضافة منتج جديد</a>
      </ul>

   </div>

</div>

<div class="page-body">
<?php if ($this->session->flashdata('message')) { ?>
     <?=$this->session->flashdata('message');?>
  <?php } ?>
   <div class="row">

      <div class="col-sm-12">

         <!-- Product list card start -->

         <div class="card">

            <div class="card-header">

               <h5><?=$title?></h5>

            </div>

            <div class="card-block">

               <div class="table-responsive">

                  <div class="table-content">

                     <div class="project-table">

                        <table id="e-product-list" class="table table-striped dt-responsive nowrap">

                           <thead>

                              <tr>

                                 <th>اسم المنتج</th>

                                 <th>اسم المنتج</th>

                                 <th>السعر</th>

                                 <th>الكمية</th>

                                 <th>العمليات</th>

                              </tr>

                           </thead>

                           <tbody>

                            <?php foreach ($products as $product) { ?>

                              <tr>

                                 <td class="pro-list-img">

                                    <img style="height: 64px; width: 64px;" src="<?=base_url('assets/uploads/files/'.$product->main_image)?>" class="img-fluid" alt="tbl">

                                 </td>

                                 <td class="pro-name">

                                    <h6><?=$product->name?></h6>

                                    <span><?=word_limiter($product->description,4)?></span>

                                 </td>

                                 <td><?=$product->price?> ريال</td>

                                 <td><?=$product->available_quantity?></td>

                                 <td class="action-icon">

                                    <a href="<?=base_url('admin_panel/products/view/'.$product->id)?>" class="btn btn-success btn-sm">عرض</a>
<a href="<?=base_url('admin_panel/products/edit/'.$product->id)?>" class="btn btn-warning btn-sm">تعديل</a>
<button value="<?=$product->id?>" data-toggle="modal" data-target="#default-Modal" onclick="deletefn(this.value)" class="btn btn-danger btn-sm">حذف</button> 
                                 </td>

                              </tr>

                            <?php } ?>  

                           </tbody>

                        </table>

                     </div>

                  </div>

               </div>

            </div>

         </div>

         <!-- Product list card end -->

      </div>

   </div>

   <!-- Add Contact Start Model start-->

   <div class="md-modal md-effect-13 addcontact" id="modal-13">

      <div class="md-content">

         <h3 class="f-26">Add Product</h3>

         <div>

            <div class="input-group">

               <input type="text" class="form-control pname" placeholder="Prodcut Name">

               <span class="input-group-addon btn btn-primary">Chooese File</span>

            </div>

            <div class="input-group">

               <span class="input-group-addon"><i class="icofont icofont-user"></i></span>

               <input type="text" class="form-control pname" placeholder="Prodcut Name">

            </div>

            <div class="input-group">

               <span class="input-group-addon"><i class="icofont icofont-user"></i></span>

               <input type="text" class="form-control pamount" placeholder="Amount">

            </div>

            <div class="input-group">

               <select id="hello-single" class="form-control stock">

                  <option value="">---- Select Stock ----</option>

                  <option value="married">In Stock</option>

                  <option value="unmarried">Out of Stock</option>

                  <option value="unmarried">Law Stock</option>

               </select>

            </div>

            <div class="text-center">

               <button type="button" class="btn btn-primary waves-effect m-r-20 f-w-600 d-inline-block save_btn">Save</button>

               <button type="button" class="btn btn-primary waves-effect m-r-20 f-w-600 md-close d-inline-block close_btn">Close</button>

            </div>

         </div>

      </div>

   </div>

   <div class="md-overlay"></div>

   <!-- Add Contact Ends Model end-->

</div>
<div class="modal fade" id="default-Modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">حذف المنتج</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>هل تريد حذف هذا المنتج؟</p>
            </div>
            <div class="modal-footer">
                <a id="yes" style="margin-left: 5px; color: white" class="btn btn-danger waves-effect ">حذف</a>
                <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-primary waves-effect waves-light ">رجوع</a>
            </div>
        </div>
    </div>
</div>
<script>
        function deletefn(val){
        var a = document.getElementById('yes');
        a.href = "<?=base_url('admin_panel/products/delete/')?>"+val;

        }
</script>



