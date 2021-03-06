<table class="widefat erp-ac-transaction-table payment-voucher-table erp-ac-transaction-form-table" style="margin: 20px 0;">
    <thead>
        <tr>
            <th class="col-ac"><?php _e( 'Account', '$domain' ); ?></th>
            <th class="col-desc"><?php _e( 'Description', '$domain' ); ?></th>
            <th class="col-qty"><?php _e( 'Qty', '$domain' ); ?></th>
            <th class="col-unit-price"><?php  _e( 'Unit Price', 'accountign' ); ?></th>
            <th class="col-discount"><?php _e( 'Discount', '$domain' ); ?></th>
            <th class="col-unit-price"><?php  _e( 'Tax(%)', 'accountign' ); ?></th>
            <th class="col-unit-price"><?php  _e( 'Tax Amount', 'accountign' ); ?></th>
            <th class="col-amount"><?php  _e( 'Amount', 'accountign' ); ?></th>
            <th class="col-action">&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        <?php

        $lilne_total = 0;
        $journals = [];
        $jor_itms['journal'] = isset( $jor_itms['journal'] ) ? $jor_itms['journal'] : [];

        foreach ( $jor_itms['journal'] as  $journal ) {
            $journals[$journal['id']] = $journal;
        }

        if ( isset( $jor_itms['item'] ) ) {
            $lilne_total = abs( $jor_itms['main']['debit'] - $jor_itms['main']['credit'] );

            foreach (  $jor_itms['item'] as $key => $item  ) {
                $journal = $journals[$item['journal_id']];

                $dropdown_html = erp_ac_render_account_dropdown_html( $dropdown, array(
                    'name'     => 'line_account[]',
                    'selected' => isset( $journal['ledger_id'] ) ? $journal['ledger_id'] : false,
                    'class'    => 'erp-select2 erp-ac-account-dropdown'
                ) );

                include WPERP_ACCOUNTING_VIEWS . '/common/transaction-table-tr-render.php';
            }

        } else {

            for ($i = 0; $i < 1; $i++) {
                include WPERP_ACCOUNTING_VIEWS . '/common/transaction-table-tr-render.php';
            }
        }

        $sub_total = isset( $transaction['sub_total'] ) ? erp_ac_get_price_for_field( $transaction['sub_total'], ['symbol' => false] ) : '0.00';

        ?>
    </tbody>
    <tfoot>
        <?php
        foreach ( $tax_labels as $tax_id => $tax_label ) {
            ?>

            <tr  class="erp-ac-tr-wrap">
                <th colspan="7" class="align-right">
                    <span class="erp-ac-tax-text"><?php echo $tax_label['label'] ;?></span>
                </th>
                <th class="col-amount">
                    <input type="text" name="tax_total" data-tax_id="<?php echo $tax_id; ?>" class="erp-ac-tax-total" readonly value="<?php echo erp_ac_get_price_for_field( $tax_label['total_amount'], ['symbol' => false] ); ?>">
                </th>
                <th>&nbsp;</th>
            </tr>
            <?php
        }

        ?>
        <tr class="erp-ac-price-total-wrap">
            <th colspan="7" class="align-right"><?php _e( 'Subtotal', 'erp' ); ?></th>
            <th class="col-amount">
                <input type="text" name="sub_total" placeholder="0.00" class="sub-total" readonly value="<?php echo $sub_total; ?>">
            </th>
            <th>&nbsp;</th>
        </tr>
        <tr class="">
            <th><a href="#" class="button add-line"><?php _e( '+ Add Line', 'erp' ); ?></a></th>
            <th colspan="6" class="align-right"><?php _e( 'Total', 'erp' ); ?></th>
            <th class="col-amount">
                <input type="text" name="price_total" class="price-total" readonly value="<?php echo erp_ac_get_price_for_field( $lilne_total, ['symbol'=>false] ); ?>">
            </th>
            <th>&nbsp;</th>
        </tr>
    </tfoot>
</table>

<table id="erp-ac-hidden-tax-table" style="display: none;">
    <tr data-tax_id="" class="erp-ac-tr-wrap">
        <th colspan="7" class="align-right">
            <span class="erp-ac-tax-text"></span>
        </th>
        <th class="col-amount">
            <input type="text" name="tax_total" data-tax_id="" class="erp-ac-tax-total" readonly value="">
        </th>
        <th>&nbsp;</th>
    </tr>
</table>
<?php






