<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="<?php echo asset_url(); ?>chromaTemplate/vendors/icheck/skins/all.css">
<?php $this->load->view('template/header.php'); ?>

<body>
    <div class="container-scroller">
    <!-- partial:../../partials/_navbar.html -->
    <?php 
    $this->load->view('template/dash_h_n1.php');        
    ?>
      
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="template-demo">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb breadcrumb-custom bg-inverse-primary">
                <li class="breadcrumb-item"><a href="#">Orders</a></li>
                <li class="breadcrumb-item"><a href="<?=base_url('orders/new_confirm_quotation_list')?>">Vendor Quotation</a></li>
                <li class="breadcrumb-item active" aria-current="page"><span>Quotations List</span></li>
              </ol>
            </nav>
          </div>

          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">Vendor Quote Details</h4>
                      <form method="post" onsubmit="return false;">
                        <div class="row">
                            <input type="hidden" name="quotation_id" id="quotation_id" value="<?php echo $quotation['quotation_id']; ?>">
                            <div class="form-group col-md-9 col-lg-9">
                                <label class="col-form-label" style="width:40%;">Ref Number : <?php echo $quotation['ref_number']; ?></label>
                                <label class="col-form-label" style="width:40%;">Warehouse : <?php echo $quotation['warehouse_name']; ?></label><br>
                                <label class="col-form-label" style="width:40%;">Description : <?php echo $quotation['description']; ?></label>
                            </div>

                            <div class="form-group col-md-3 col-lg-3">
                                <button type="button" class="btn btn-warning" style="float:right" data-toggle="modal" data-target="#view_product" data-whatever="@getbootstrap">Click To View Quotation Products</button>
                            </div>
                        </div>

                        <div class="row mb-3">
                          <div class="col-md-12 col-lg-12">
                            <table class="table table-bordered" id="vendor-table" style="width: 100%;display: block;overflow-x: auto;white-space: nowrap;">
                              <thead>
                                <tr>
                                    <!-- <th><label>Sl.No.</label></th> -->
                                    <th><label>Product Details</label></th>
                                    <th><label>Vendor Details</label></th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                $i = 1;
                                foreach ($quotation_products as $item) {
                                  ?>
                                  <tr class="product_detail">
                                    <!-- <td><?=$i?></td> -->
                                    <td class="text-left font-weight-bold product_detail_<?=$item['qp_id']?>" id="product_detail_<?php echo $item['product_id']; ?>">
                                      Product : <?=$item['product_name'].' <br> Category : '.$item['category_name'].' <br> Sub Category 1 : '.$item['s1name'].' <br> Sub Category 2 : '.$item['s2name']?>
                                      <br> Quantity : <?=$item['quantity']?>
                                    </td>
                                    <td class="text-left font-weight-bold">
                                      <input type="hidden" name="qp_id[]" value="<?=$item['qp_id']?>">
                                      <input type="hidden" name="quotation_id[]" id="quotation_id<?=$item['qp_id']?>" value="<?=$item['quotation_id']?>">
                                      <input type="hidden" name="product_id[]" id="product_id<?=$item['qp_id']?>" value="<?=$item['product_id']?>">
                                      <input type="hidden" name="qty[]" id="qty<?=$item['qp_id']?>" value="<?=$item['quantity']?>">
                                      <table class="table table-bordered" id="vendor-table">
                                        <thead>
                                          <tr>
                                            <th><label>Vendor</label></th>
                                            <th><label>QTY</label></th>
                                            <th><label>Free Qty</label></th>
                                            <th><label>Wholesale Price</label></th>
                                            <th><label>Wholesale Amount</label></th>
                                            <th><label>Retail Price</label></th>
                                            <th><label>Retail Amount</label></th>
                                            <th><label>Total Amount</label></th>
                                            <th><label>Action</label></th>
                                            <th><label>Required QTY</label></th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <?php
                                          $vendor_quotes = $this->order_model->get_quotation_product_price(0,$item['quotation_id'],$item['qp_id']);
                                          // echo '<pre>';print_r($vendor_quotes);echo '</pre>';
                                          // echo $this->db->last_query();
                                          foreach ($vendor_quotes as $vendor_item) {
                                            ?>
                                            <tr>
                                              <input type="hidden" name="vqd_id[]" class="vqd_id<?=$item['qp_id']?>" supplier_id="<?=$vendor_item['supplier_id']?>" vendor_quote_id="<?=$vendor_item['vendor_quote_id']?>" value="<?=$vendor_item['vqd_id']?>"/>
                                              <td><?=$vendor_item['supplier_name']?></td>
                                              <td><?=$vendor_item['quantity']?></td>
                                              <td><?=$vendor_item['free_quantity']?></td>
                                              <td><?=$vendor_item['wholesale_price']?></td>
                                              <td><?=$vendor_item['w_total_amount']?></td>
                                              <td><?=$vendor_item['retail_price']?></td>
                                              <td><?=$vendor_item['r_total_amount']?></td>
                                              <td><?=$vendor_item['total_retail_price']?></td>
                                              <td>
                                                <label>
                                                  <input type="checkbox" value="1" id="approve_<?=$item['qp_id']?>_<?=$item['product_id']?>_<?=$vendor_item['supplier_id']?>_<?=$vendor_item['vendor_quote_id']?>" onchange="enabledQty(this,<?=$item['qp_id']?>,<?=$item['product_id']?>,<?=$vendor_item['supplier_id']?>,<?=$vendor_item['vendor_quote_id']?>)" /> Approve
                                                </label>
                                              </td>
                                              <td>
                                                <input type="number" class="form-control" disabled="true" name="approve_qty_<?=$item['product_id']?>[]" id="approve_qty_<?=$item['qp_id']?>_<?=$item['product_id']?>_<?=$vendor_item['supplier_id']?>_<?=$vendor_item['vendor_quote_id']?>" value="0" min="1" max="<?php echo $vendor_item['quantity']?>">
                                              </td>
                                            </tr>
                                            <?php
                                          }
                                          ?>
                                        </tbody>
                                      </table>
                                    </td>
                                  </tr>
                                  <?php
                                  $i++;
                                }
                                ?>
                              </tbody>
                                
                            </table>
                            <button type="button" onclick="validateQuote()" class="btn btn-warning">Approve Quotation</button>
                          </div>
                        </div>
                        
                        <div class="row">
                          <div class="col-md-12 col-lg-12 mt-3">
                            <h3>Vendor Quotation Details</h3>
                            <div class="accordion accordion-multiple-outline" id="accordion-2" role="tablist">
                                <?php
                                $q = 1;
                                foreach ($quotations as $quote) {
                                    ?>
                                    <div class="card">
                                        <div class="card-header" role="tab" id="heading-<?=$q?>">
                                            <h6 class="mb-0">
                                                <a data-toggle="collapse" href="#collapseOne-<?=$q?>" aria-expanded="true" aria-controls="collapseOne-<?=$q?>">
                                                    <b><?=$q?>. </b> Vendor Name : <?=$quote['supplier']?>
                                                </a>
                                            </h6>
                                        </div>

                                        <div id="collapseOne-<?=$q?>" class="collapse show" role="tabpanel" aria-labelledby="headingOne-<?=$q?>" data-parent="#accordion-<?=$q?>">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12 col-lg-12 table-responsive">
                                                        <table class="table table-bordered" id="vendor-table" style="width: 100%">
                                                            <thead>
                                                            <tr>
                                                                <th width="20%">
                                                                <label>Vendor Name</label>
                                                                </th>
                                                                <th width="20%">
                                                                <label>Delivery Days</label>
                                                                </th>
                                                                <th width="20%">
                                                                <label>Total Price</label>
                                                                </th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td><?php echo $quote['supplier']; ?></td>
                                                                    <td><?php echo $quote['delivery_days']; ?></td>                                
                                                                    <td><?php echo $quote['grand_wholesale_price']; ?></td>            
                                                                </tr>
                                                            </tbody>
                                                            
                                                        </table>
                                                    </div>

                                                    <div class="col-md-12 col-lg-12">
                                                        <br><p class="card-description">Product Details</p>
                                                        <hr>
                                                        <?php
                                                        foreach ($quote['products'] as $products) {
                                                            ?>
                                                            <div class="row" id="vendor_<?=$quote['vendor_quote_id']?>_product_<?=$products['qp_id']?>">
                                                                <div class="form-group col-md-2 col-lg-2">
                                                                    <label class="col-form-label">Product Name</label>
                                                                    <input type="text" class="form-control" name="product_name" value="<?php echo $products['product_name']?>" disabled="">
                                                                </div>

                                                                <div class="form-group col-md-2 col-lg-2">
                                                                    <label class="col-form-label">Category</label>
                                                                    <input type="text" class="form-control" value="<?php echo $products['category'] ?>" disabled>
                                                                </div>

                                                                <div class="form-group col-md-2 col-lg-2">
                                                                    <label class="col-form-label">Sub Category One</label>
                                                                    <input type="text" class="form-control" value="<?php echo $products['sub_cat_one']?>" disabled>
                                                                </div>

                                                                <div class="form-group col-md-2 col-lg-2">
                                                                    <label class="col-form-label">Sub Category Two</label>
                                                                    <input type="text" class="form-control" value="<?php echo $products['sub_cat_two']?>" disabled>
                                                                </div>

                                                                <div class="form-group col-md-1 col-lg-1">
                                                                    <label class="col-form-label">Quantity</label>
                                                                    <input type="text" class="form-control" name="quantity" value="<?php echo $products['quantity']?>" disabled="">
                                                                </div>

                                                                <div class="form-group col-md-1 col-lg-1">
                                                                    <label class="col-form-label">Free Qty</label>
                                                                    <input type="text" class="form-control" name="free_quantity" value="<?php echo $products['free_quantity']?>"  disabled>
                                                                </div>

                                                                <div class="form-group col-md-2 col-lg-2">
                                                                    <label for="name" class="col-form-label">Brand:</label>
                                                                    <input type="text" class="form-control" name="brand_name" value="<?php echo $products['brand']; ?>"  disabled>
                                                                </div>

                                                                <div class="form-group col-md-2 col-lg-2">
                                                                    <label class="col-form-label">Wholesale Price</label>
                                                                    <input type="text" class="form-control" name="wholesale_price" value="<?php echo $products['wholesale_price']?>" disabled>
                                                                </div>

                                                                <div class="form-group col-md-2 col-lg-2">
                                                                    <label class="col-form-label">Tax type:</label><br>
                                                                    <?php if($products['w_tax_type'] == "0") {$w_tax_type = "Exclusive";} else{$w_tax_type = "Inclusive";}?>
                                                                    <input type="text" class="form-control" name="w_tax_type" value="<?php echo $w_tax_type; ?>"  disabled>
                                                                </div>

                                                                <div class="form-group col-md-1 col-lg-1">
                                                                    <label class="col-form-label">CGST %:</label>
                                                                    <input type="text"  class="form-control" name="w_cgst" value="<?php echo $products['w_cgst']?>" disabled>
                                                                </div>

                                                                <div class="form-group col-md-1 col-lg-1">
                                                                    <label class="col-form-label">SGST %:</label>
                                                                    <input type="text"  class="form-control" name="w_sgst" value="<?php echo $products['w_sgst']?>" disabled>
                                                                </div>

                                                                <div class="form-group col-md-1 col-lg-1">
                                                                    <label class="col-form-label">IGST %:</label>
                                                                    <input type="text"  class="form-control" name="w_igst" value="<?php echo $products['w_igst']?>" disabled>
                                                                </div>

                                                                <div class="form-group col-md-1 col-lg-1">
                                                                    <label class="col-form-label">TotalTax:</label>
                                                                    <input type="text" class="form-control" name="w_tax_amount" value="<?php echo $products['w_tax_amount']?>" disabled="">
                                                                </div>

                                                                <div class="form-group col-md-1 col-lg-1">
                                                                    <label class="col-form-label">WH Amt</label>
                                                                    <input type="text" class="form-control" name="w_total_amount" value="<?php echo $products['w_total_amount']?>" disabled>
                                                                </div>

                                                                <div class="form-group col-md-1 col-lg-1">
                                                                    <label class="col-form-label">Total Price:</label>
                                                                    <input type="text" class="form-control" name="total_wholesale_price" value="<?php echo $products['total_wholesale_price']?>" disabled="">
                                                                </div>

                                                                <div class="form-group col-md-2 col-lg-2">
                                                                    <label class="col-form-label">Retail Price:</label>
                                                                    <input type="text" class="form-control r_total_amount" name="retail_price" value="<?php echo $products['retail_price']?>" disabled="">
                                                                </div>

                                                                <div class="form-group col-md-2 col-lg-2">
                                                                    <label class="col-form-label">Tax type:</label><br>
                                                                    <?php if($products['r_tax_type'] == "0") {$r_tax_type = "Exclusive";} else{$r_tax_type = "Inclusive";}?>
                                                                    <input type="text" class="form-control" name="r_tax_type" value="<?php echo $r_tax_type; ?>"  disabled>
                                                                </div>

                                                                <div class="form-group col-md-1 col-lg-1">
                                                                    <label class="col-form-label">CGST %:</label>
                                                                    <input type="text" class="form-control" name="r_cgst[]" value="<?php echo $products['r_cgst']?>" disabled="">
                                                                </div>

                                                                <div class="form-group col-md-1 col-lg-1">
                                                                    <label class="col-form-label">SGST %:</label>
                                                                    <input type="text"  class="form-control" name="r_sgst[]" value="<?php echo $products['r_sgst']?>" disabled="">
                                                                </div>

                                                                <div class="form-group col-md-1 col-lg-1">
                                                                    <label class="col-form-label">IGST %:</label>
                                                                    <input type="text" class="form-control" name="r_igst[]" value="<?php echo $products['r_igst']?>" disabled="">
                                                                </div>

                                                                <div class="form-group col-md-1 col-lg-1">
                                                                    <label class="col-form-label">TotalTax:</label>
                                                                    <input type="text" class="form-control" name="r_tax_amount[]" value="<?php echo $products['r_tax_amount']?>" disabled="">
                                                                </div>

                                                                <div class="form-group col-md-1 col-lg-1">
                                                                    <label class="col-form-label">Retail Amt</label>
                                                                    <input type="text" class="form-control" name="r_total_amount"  value="<?php echo $products['r_total_amount']?>" disabled>
                                                                </div>

                                                                <div class="form-group col-md-2 col-lg-2">
                                                                    <label class="col-form-label">Total Price:</label>
                                                                    <input type="text" class="form-control" name="total_retail_price[]" value="<?php echo $products['total_retail_price']?>" disabled="">
                                                                </div>

                                                                <!-- <div class="form-group col-md-2 col-lg-2">
                                                                    <label class="col-form-label">QTY(Need to be supplied)</label>
                                                                    <input type="number" class="form-control" name="req_qty[]" value="0" min="0" max="<?php echo $products['quantity']?>">
                                                                </div> -->
                                                            </div>
                                                            <hr>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>

                                                    <div class="form-group col-md-3 col-lg-3">
                                                        <label for="address" class="col-form-label">Conditions:</label>
                                                        <textarea class="form-control" name="conditions" disabled=""><?php echo $quote['vendor_quotation'][0]['conditions']?></textarea>
                                                    </div>

                                                    <div class="form-group col-md-2 col-lg-2">
                                                        <label class="col-form-label">Delivery Days</label>
                                                        <input type="number" class="form-control" name="delivery_days" disabled="" value="<?php echo $quote['vendor_quotation'][0]['delivery_days']?>">
                                                    </div>

                                                    <div class="form-group col-md-2 col-lg-2">
                                                        <label class="col-form-label">Transport Cost:</label>
                                                        <input type="text" class="form-control" name="transport_cost" value="<?php echo $quote['vendor_quotation'][0]['transport_cost']?>" disabled="" >
                                                    </div>

                                                    <div class="form-group col-md-2 col-lg-2">
                                                        <label class="col-form-label">Grand WH Price:</label>
                                                        <input type="text" class="form-control" name="grand_wholesale_price" value="<?php echo $quote['vendor_quotation'][0]['grand_wholesale_price']?>" disabled="">
                                                    </div>

                                                    <div class="form-group col-md-2 col-lg-2">
                                                        <label class="col-form-label">Grand Retail Price:</label>
                                                        <input type="text" class="form-control" name="grand_retail_price" value="<?php echo $quote['vendor_quotation'][0]['grand_retail_price']?>" disabled="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    $q++;
                                }
                                ?>
                            </div>
                          </div>
                        </div>

                      </form>
                    </div>
                </div>
            </div>
            <!--
            <div class="col-12 table-responsive">
              <div class="card">
                <div class="card-body">

                  <div class="row">
                    <input type="hidden" name="quotation_id" value="<?php echo $quotation['quotation_id']; ?>">
                    <div class="form-group col-md-3 col-lg-3">
                      <label class="col-form-label">Ref Number:</label>
                      <input type="text" class="form-control" name="ref_number" value="<?php echo $quotation['ref_number']; ?>" disabled>
                    </div>

                    <div class="form-group col-md-3 col-lg-3">
                      <br>
                      <span>
                        <button type="button" class="btn btn-warning" style="float:right" data-toggle="modal" data-target="#view_product" data-whatever="@getbootstrap">Click To View Quotation Products</button>
                      </span>
                    </div>

                    <div class="table-responsive">
                      <table class="table table-bordered" id="vendor-table" style="width: 100%">
                        <thead>
                          <tr>
                            <td width="20%">
                              <label>Sl.No</label>
                            </td>
                            <td width="20%">
                              <label>Vendor Name</label>
                            </td>
                            <td width="20%">
                              <label>Delivery Days</label>
                            </td>
                            <td width="20%">
                              <label>Total Price</label>
                            </td>
                            <td width="20%">
                              <label>Approve/Reject</label>
                            </td>
                            <td width="20%">
                              <label>View</label>
                            </td>
                          </tr>
                        </thead>
                        <tbody>
                        <?php $i=1; foreach($quotations as $row) {
                          ?>
                          <tr>
                              <td><?php echo $i; ?></td>
                              <td><?php echo $row['supplier']; ?></td>
                              <td><?php echo $row['delivery_days']; ?></td>                                
                              <td><?php echo $row['grand_wholesale_price']; ?></td>
                              <td>
                                <a href="<?= base_url()?>orders/confirm_vendor_quotation/<?php echo $row['vendor_quote_id']?>">Approve</a>
                              </td>                                   
                              <td>
                                <a href="<?= base_url()?>orders/quotation_proposal_details/<?php echo $row['vendor_quote_id']?>" class="btn btn-warning" target="_blank">View Quotation Details</a>
                              </td>                                                                
                          </tr>
                        <?php $i++;} ?>
                        </tbody>
                        
                      </table>
                    </div>

                  </div>
                  
                </div>
              </div>


            </div>
            -->
          </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
        
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->

      <!-- Modal Start -->
      <div class="modal fade" id="view_product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" style="width:70%; left:9vw" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Product Details</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <form method="post" action="<?php echo base_url('products/addProduct'); ?>">
                <div class="row">

                    <div class="form-group col-md-3 col-lg-3">
                        <label class="col-form-label">Ref Number:</label>
                        <input type="text" class="form-control" name="ref_number" value="<?php echo $quotation['ref_number']; ?>" disabled>
                      </div>

                      <div class="form-group col-md-3 col-lg-3">
                        <label class="col-form-label">Warehouse:</label><br>
                        <?php $warehouse = $this->db->select('w.name')->from('warehouse w')
                        ->where(array('w.id' => $quotation['warehouse_id']))->get()->row_array(); ?>
                        <input type="text" class="form-control" name="warehouse" value="<?php echo $warehouse['name']; ?>" disabled>
                      </div>

                      <div class="form-group col-md-3 col-lg-3">
                        <label for="address" class="col-form-label">Description:</label>
                        <textarea class="form-control" name="description" disabled><?php echo $quotation['description']?></textarea>
                      </div>
                    </div>

                    <div class="form-group col-md-12 col-lg-12">
                      <table class="table table-bordered" id="view-product-table" style="width: 100%">
                        <tr>
                          <td style="width: 20%">
                            <label>Product Name</label>
                          </td>
                          <td style="width: 20%">
                            <label>Category</label>
                          </td>
                          <td style="width: 20%">
                            <label>Sub Category One</label>
                          </td>
                          <td style="width: 20%">
                            <label>Sub Category Two</label>
                          </td>
                          <td style="width: 5%">
                            <label>Quantity</label>
                          </td>
                        </tr>
                        <?php foreach($quotation_products as $row) {?>
                        <tr>
                          <td>
                            <input type="text" class="form-control" name="product_name" value="<?php echo $row['product_name']?>" disabled="">
                          </td>
                          <td>
                            <?php $category = $this->db->select('*')->from('category')->where('id',$row['category_id'])->get()->row_array(); ?>
                            <input type="text" class="form-control" value="<?php echo $category['name'] ?>" disabled>
                          </td>
                          <td>
                            <?php $sub1 = $this->db->select('*')->from('sub_categories_one')->where(array('id' => $row['sub_category_one_id']))->get()->row_array(); ?>
                            <input type="text" class="form-control" value="<?php echo $sub1['name']?>" disabled>
                          </td>
                          <td>
                            <?php $sub2 = $this->db->select('*')->from('sub_categories_two')->where(array('id' => $row['sub_category_two_id']))->get()->row_array(); ?>
                            <input type="text" class="form-control" value="<?php echo $sub2['name']?>" disabled>
                          </td>
                          <td>
                            <input type="text" class="form-control" name="quantity" value="<?php echo $row['quantity']?>" disabled>
                          </td> 
                        </tr>
                        <?php } ?>
                      </table>
                    </div>
                
                </div>                                                                                  
            </div>
            <!-- <div class="modal-footer">
              <button type="submit" class="btn btn-success">Add Product</button>
              <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div> -->
            </div>
            
          </div>
        </div>
      </div>
      <!-- Modal Ends -->
  </div>

    <style type="text/css"> 
      #view-product-table td, th {
        border: 1px solid #1d1a1a !important;
        text-align: center;
        padding: 5px !important;
      }

      #vendor-table td, th {
        border: 1px solid #1d1a1a !important;
        text-align: center;
        padding: 12px !important;
      }
      .modal .modal-dialog .modal-content .modal-body {
        padding: 5px 26px !important;
      }

      .modal .modal-dialog .modal-content .modal-header {
        padding: 15px 26px;
      }
    </style>


  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="<?php echo asset_url(); ?>chromaTemplate//vendors/js/vendor.bundle.base.js"></script>
  <script src="<?php echo asset_url(); ?>chromaTemplate//vendors/js/vendor.bundle.addons.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="<?php echo asset_url(); ?>chromaTemplate//js/off-canvas.js"></script>
  <script src="<?php echo asset_url(); ?>chromaTemplate//js/hoverable-collapse.js"></script>
  <script src="<?php echo asset_url(); ?>chromaTemplate//js/misc.js"></script>
  <script src="<?php echo asset_url(); ?>chromaTemplate//js/settings.js"></script>
  <script src="<?php echo asset_url(); ?>chromaTemplate//js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="<?php echo asset_url(); ?>chromaTemplate//js/data-table.js"></script>
  <!-- End custom js for this page-->
  <script src="<?php echo asset_url(); ?>chromaTemplate/js/select2.js"></script>
  <script src="<?php echo asset_url(); ?>chromaTemplate/js/iCheck.js"></script>

  <script>
    function enabledQty(ele, qp_id = 0, product_id = 0, supplier_id = 0,  vqd_id = 0){
      // console.log(product_id,supplier_id)
      // console.log(ele)
      // console.log($(ele).is(':checked'))
      if( $(ele).is(':checked') ){
        $('#approve_qty_'+qp_id+'_'+product_id+'_'+supplier_id+'_'+vqd_id).attr('disabled',false)
      }else{
        $('#approve_qty_'+qp_id+'_'+product_id+'_'+supplier_id+'_'+vqd_id).val(0);
        $('#approve_qty_'+qp_id+'_'+product_id+'_'+supplier_id+'_'+vqd_id).attr('disabled',true)
      }      
    }

    function validateQuote(){
      let payload = {quotation_id:0,products:[]};
      payload.quotation_id = $.trim($('#quotation_id').val());

      if( confirm('Are you sure want to proceed?') ){

        $('input[name^="qp_id"]').each( function() { 
          // console.log(this.value); 
          let qp_id = this.value;
          let quotation_id = $.trim($('#quotation_id'+qp_id).val());
          let product_id = $.trim($('#product_id'+qp_id).val());
          let qty = $.trim($('#qty'+qp_id).val());
          let total_qty = 0;
          let product_detail = $.trim($('.product_detail_'+qp_id).html().replace(/<br>/g,"\n"))
          // console.log("Quotation Product Id : "+qp_id);
          // console.log("Quotation Id : "+quotation_id);
          // console.log("Product Id : "+product_id);
          // console.log("Qty : "+qty);


          if( $('.vqd_id'+qp_id).length ){
            $('.vqd_id'+qp_id).each( function() {
              let vpd_id = this.value;
              let supplier_id = $(this).attr('supplier_id');
              let vendor_quote_id = $(this).attr('vendor_quote_id');

              // console.log("========================");
              // console.log("Vendor Quotation Product Id : "+vpd_id);
              // console.log("Supplier Id : "+supplier_id);
              // console.log("Vendor Quote Id : "+vendor_quote_id);
              // console.log("========================");

              let status = 0; //0->pending 1->approved 2->unapproved
              let approved_qty = 0;

              // id="approve_<?=$item['qp_id']?>_<?=$item['product_id']?>_<?=$vendor_item['supplier_id']?>_<?=$vendor_item['vqd_id']?>"
              if( $("#approve_"+qp_id+"_"+product_id+"_"+supplier_id+"_"+vendor_quote_id).is(':checked') ){
                status = 1;
                approved_qty = parseInt($("#approve_qty_"+qp_id+"_"+product_id+"_"+supplier_id+"_"+vendor_quote_id).val());
                if( approved_qty > qty ){
                  // alert('Please enter qty within '+qty);
                  alert('Please enter qty within '+qty+' for below product \n'+product_detail);
                  return false;
                }
                total_qty = total_qty + approved_qty;
              }else{
                status = 2;
              } 

              // console.log("Quotation Product Id : "+qp_id);
              // console.log("Status : "+status);
              // console.log("Approved Qty : "+approved_qty);
              // console.log("Total Qty : "+total_qty);
              
              let itemData = {
                qp_id : qp_id,
                product_id : product_id,
                supplier_id : supplier_id,
                vendor_quote_id : vendor_quote_id,
                vpd_id : vpd_id,
                qty : qty,
                alloted_qty : approved_qty,
                status : status
              };
              payload.products.push(itemData);
            });

            if( total_qty == 0 ){
              alert('Please allocate qty for below product to proceed!!! \n'+product_detail);
              return false;
            }else if( total_qty > qty ){
              alert('Please allocate qty within '+qty+' for below product \n'+product_detail);
              return false;
            }else if( total_qty < qty ){
              alert('Please allocate qty for below product to proceed!!! \n'+product_detail);
              return false;
            }else{
              console.log("QTY allocated successfully");
              console.log(product_detail);
              console.log("Product Id : "+product_id);
              console.log("Qty : "+qty);
              console.log("Alloted QTY : ",total_qty);
            }
          }

          total_qty = 0;

        });
        // console.log(payload);
        $.ajax({
          url: '<?=base_url("orders/approvedVendorQuotes")?>',
          type: 'POST',
          data: payload,
          cache: false,
          dataType: 'json',
          success : function(result){
            // console.log(result);
            if( result.status == true ){
              alert(result.msg);
              window.location.href = "<?=base_url('orders/new_confirm_quotation_list')?>";
            }else{
              alert(result.msg);
            }
          }
        });

        return false;
      }
      return false;
    }
  </script>
</body>

</html>