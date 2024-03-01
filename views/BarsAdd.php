<?php

namespace PHPMaker2024\project2;

// Page object
$BarsAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { bars: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fbarsadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fbarsadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["address", [fields.address.visible && fields.address.required ? ew.Validators.required(fields.address.caption) : null], fields.address.isInvalid],
            ["state", [fields.state.visible && fields.state.required ? ew.Validators.required(fields.state.caption) : null], fields.state.isInvalid],
            ["location", [fields.location.visible && fields.location.required ? ew.Validators.required(fields.location.caption) : null], fields.location.isInvalid],
            ["dihiresira", [fields.dihiresira.visible && fields.dihiresira.required ? ew.Validators.required(fields.dihiresira.caption) : null], fields.dihiresira.isInvalid],
            ["genzebtype", [fields.genzebtype.visible && fields.genzebtype.required ? ew.Validators.required(fields.genzebtype.caption) : null], fields.genzebtype.isInvalid],
            ["birramount", [fields.birramount.visible && fields.birramount.required ? ew.Validators.required(fields.birramount.caption) : null, ew.Validators.float], fields.birramount.isInvalid],
            ["description", [fields.description.visible && fields.description.required ? ew.Validators.required(fields.description.caption) : null], fields.description.isInvalid],
            ["created_at", [fields.created_at.visible && fields.created_at.required ? ew.Validators.required(fields.created_at.caption) : null, ew.Validators.datetime(fields.created_at.clientFormatPattern)], fields.created_at.isInvalid],
            ["updated_at", [fields.updated_at.visible && fields.updated_at.required ? ew.Validators.required(fields.updated_at.caption) : null], fields.updated_at.isInvalid],
            ["updated_by", [fields.updated_by.visible && fields.updated_by.required ? ew.Validators.required(fields.updated_by.caption) : null], fields.updated_by.isInvalid]
        ])

        // Form_CustomValidate
        .setCustomValidate(
            function (fobj) { // DO NOT CHANGE THIS LINE! (except for adding "async" keyword)!
                    // Your custom validation code here, return false if invalid.
                    return true;
                }
        )

        // Use JavaScript validation or not
        .setValidateRequired(ew.CLIENT_VALIDATE)

        // Dynamic selection lists
        .setLists({
        })
        .build();
    window[form.id] = form;
    currentForm = form;
    loadjs.done(form.id);
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fbarsadd" id="fbarsadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="bars">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->address->Visible) { // address ?>
    <div id="r_address"<?= $Page->address->rowAttributes() ?>>
        <label id="elh_bars_address" for="x_address" class="<?= $Page->LeftColumnClass ?>"><?= $Page->address->caption() ?><?= $Page->address->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->address->cellAttributes() ?>>
<span id="el_bars_address">
<input type="<?= $Page->address->getInputTextType() ?>" name="x_address" id="x_address" data-table="bars" data-field="x_address" value="<?= $Page->address->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->address->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->address->formatPattern()) ?>"<?= $Page->address->editAttributes() ?> aria-describedby="x_address_help">
<?= $Page->address->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->address->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->state->Visible) { // state ?>
    <div id="r_state"<?= $Page->state->rowAttributes() ?>>
        <label id="elh_bars_state" for="x_state" class="<?= $Page->LeftColumnClass ?>"><?= $Page->state->caption() ?><?= $Page->state->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->state->cellAttributes() ?>>
<span id="el_bars_state">
<input type="<?= $Page->state->getInputTextType() ?>" name="x_state" id="x_state" data-table="bars" data-field="x_state" value="<?= $Page->state->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->state->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->state->formatPattern()) ?>"<?= $Page->state->editAttributes() ?> aria-describedby="x_state_help">
<?= $Page->state->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->state->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->location->Visible) { // location ?>
    <div id="r_location"<?= $Page->location->rowAttributes() ?>>
        <label id="elh_bars_location" for="x_location" class="<?= $Page->LeftColumnClass ?>"><?= $Page->location->caption() ?><?= $Page->location->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->location->cellAttributes() ?>>
<span id="el_bars_location">
<input type="<?= $Page->location->getInputTextType() ?>" name="x_location" id="x_location" data-table="bars" data-field="x_location" value="<?= $Page->location->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->location->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->location->formatPattern()) ?>"<?= $Page->location->editAttributes() ?> aria-describedby="x_location_help">
<?= $Page->location->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->location->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->dihiresira->Visible) { // dihiresira ?>
    <div id="r_dihiresira"<?= $Page->dihiresira->rowAttributes() ?>>
        <label id="elh_bars_dihiresira" for="x_dihiresira" class="<?= $Page->LeftColumnClass ?>"><?= $Page->dihiresira->caption() ?><?= $Page->dihiresira->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->dihiresira->cellAttributes() ?>>
<span id="el_bars_dihiresira">
<input type="<?= $Page->dihiresira->getInputTextType() ?>" name="x_dihiresira" id="x_dihiresira" data-table="bars" data-field="x_dihiresira" value="<?= $Page->dihiresira->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->dihiresira->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->dihiresira->formatPattern()) ?>"<?= $Page->dihiresira->editAttributes() ?> aria-describedby="x_dihiresira_help">
<?= $Page->dihiresira->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->dihiresira->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->genzebtype->Visible) { // genzebtype ?>
    <div id="r_genzebtype"<?= $Page->genzebtype->rowAttributes() ?>>
        <label id="elh_bars_genzebtype" for="x_genzebtype" class="<?= $Page->LeftColumnClass ?>"><?= $Page->genzebtype->caption() ?><?= $Page->genzebtype->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->genzebtype->cellAttributes() ?>>
<span id="el_bars_genzebtype">
<input type="<?= $Page->genzebtype->getInputTextType() ?>" name="x_genzebtype" id="x_genzebtype" data-table="bars" data-field="x_genzebtype" value="<?= $Page->genzebtype->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->genzebtype->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->genzebtype->formatPattern()) ?>"<?= $Page->genzebtype->editAttributes() ?> aria-describedby="x_genzebtype_help">
<?= $Page->genzebtype->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->genzebtype->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->birramount->Visible) { // birramount ?>
    <div id="r_birramount"<?= $Page->birramount->rowAttributes() ?>>
        <label id="elh_bars_birramount" for="x_birramount" class="<?= $Page->LeftColumnClass ?>"><?= $Page->birramount->caption() ?><?= $Page->birramount->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->birramount->cellAttributes() ?>>
<span id="el_bars_birramount">
<input type="<?= $Page->birramount->getInputTextType() ?>" name="x_birramount" id="x_birramount" data-table="bars" data-field="x_birramount" value="<?= $Page->birramount->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->birramount->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->birramount->formatPattern()) ?>"<?= $Page->birramount->editAttributes() ?> aria-describedby="x_birramount_help">
<?= $Page->birramount->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->birramount->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->description->Visible) { // description ?>
    <div id="r_description"<?= $Page->description->rowAttributes() ?>>
        <label id="elh_bars_description" for="x_description" class="<?= $Page->LeftColumnClass ?>"><?= $Page->description->caption() ?><?= $Page->description->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->description->cellAttributes() ?>>
<span id="el_bars_description">
<textarea data-table="bars" data-field="x_description" name="x_description" id="x_description" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->description->getPlaceHolder()) ?>"<?= $Page->description->editAttributes() ?> aria-describedby="x_description_help"><?= $Page->description->EditValue ?></textarea>
<?= $Page->description->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->description->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <div id="r_created_at"<?= $Page->created_at->rowAttributes() ?>>
        <label id="elh_bars_created_at" for="x_created_at" class="<?= $Page->LeftColumnClass ?>"><?= $Page->created_at->caption() ?><?= $Page->created_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->created_at->cellAttributes() ?>>
<span id="el_bars_created_at">
<input type="<?= $Page->created_at->getInputTextType() ?>" name="x_created_at" id="x_created_at" data-table="bars" data-field="x_created_at" value="<?= $Page->created_at->EditValue ?>" placeholder="<?= HtmlEncode($Page->created_at->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->created_at->formatPattern()) ?>"<?= $Page->created_at->editAttributes() ?> aria-describedby="x_created_at_help">
<?= $Page->created_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->created_at->getErrorMessage() ?></div>
<?php if (!$Page->created_at->ReadOnly && !$Page->created_at->Disabled && !isset($Page->created_at->EditAttrs["readonly"]) && !isset($Page->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fbarsadd", "datetimepicker"], function () {
    let format = "<?= DateFormat(0) ?>",
        options = {
            localization: {
                locale: ew.LANGUAGE_ID + "-u-nu-" + ew.getNumberingSystem(),
                hourCycle: format.match(/H/) ? "h24" : "h12",
                format,
                ...ew.language.phrase("datetimepicker")
            },
            display: {
                icons: {
                    previous: ew.IS_RTL ? "fa-solid fa-chevron-right" : "fa-solid fa-chevron-left",
                    next: ew.IS_RTL ? "fa-solid fa-chevron-left" : "fa-solid fa-chevron-right"
                },
                components: {
                    hours: !!format.match(/h/i),
                    minutes: !!format.match(/m/),
                    seconds: !!format.match(/s/i)
                },
                theme: ew.getPreferredTheme()
            }
        };
    ew.createDateTimePicker("fbarsadd", "x_created_at", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fbarsadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fbarsadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
<?php } ?>
    </div><!-- /buttons offset -->
<?= $Page->IsModal ? "</template>" : "</div>" ?><!-- /buttons .row -->
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("bars");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
