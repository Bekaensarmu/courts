<?php

namespace PHPMaker2024\project2;

// Page object
$CaseChargesAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { case_charges: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fcase_chargesadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fcase_chargesadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["deptName", [fields.deptName.visible && fields.deptName.required ? ew.Validators.required(fields.deptName.caption) : null], fields.deptName.isInvalid],
            ["mid", [fields.mid.visible && fields.mid.required ? ew.Validators.required(fields.mid.caption) : null], fields.mid.isInvalid],
            ["rank", [fields.rank.visible && fields.rank.required ? ew.Validators.required(fields.rank.caption) : null], fields.rank.isInvalid],
            ["name", [fields.name.visible && fields.name.required ? ew.Validators.required(fields.name.caption) : null], fields.name.isInvalid],
            ["address", [fields.address.visible && fields.address.required ? ew.Validators.required(fields.address.caption) : null], fields.address.isInvalid],
            ["state", [fields.state.visible && fields.state.required ? ew.Validators.required(fields.state.caption) : null], fields.state.isInvalid],
            ["crimeDescription", [fields.crimeDescription.visible && fields.crimeDescription.required ? ew.Validators.required(fields.crimeDescription.caption) : null], fields.crimeDescription.isInvalid],
            ["crimeDate", [fields.crimeDate.visible && fields.crimeDate.required ? ew.Validators.required(fields.crimeDate.caption) : null, ew.Validators.datetime(fields.crimeDate.clientFormatPattern)], fields.crimeDate.isInvalid],
            ["ChargeDate", [fields.ChargeDate.visible && fields.ChargeDate.required ? ew.Validators.required(fields.ChargeDate.caption) : null, ew.Validators.datetime(fields.ChargeDate.clientFormatPattern)], fields.ChargeDate.isInvalid],
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
<form name="fcase_chargesadd" id="fcase_chargesadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="case_charges">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->deptName->Visible) { // deptName ?>
    <div id="r_deptName"<?= $Page->deptName->rowAttributes() ?>>
        <label id="elh_case_charges_deptName" for="x_deptName" class="<?= $Page->LeftColumnClass ?>"><?= $Page->deptName->caption() ?><?= $Page->deptName->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->deptName->cellAttributes() ?>>
<span id="el_case_charges_deptName">
<input type="<?= $Page->deptName->getInputTextType() ?>" name="x_deptName" id="x_deptName" data-table="case_charges" data-field="x_deptName" value="<?= $Page->deptName->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->deptName->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->deptName->formatPattern()) ?>"<?= $Page->deptName->editAttributes() ?> aria-describedby="x_deptName_help">
<?= $Page->deptName->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->deptName->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->mid->Visible) { // mid ?>
    <div id="r_mid"<?= $Page->mid->rowAttributes() ?>>
        <label id="elh_case_charges_mid" for="x_mid" class="<?= $Page->LeftColumnClass ?>"><?= $Page->mid->caption() ?><?= $Page->mid->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->mid->cellAttributes() ?>>
<span id="el_case_charges_mid">
<input type="<?= $Page->mid->getInputTextType() ?>" name="x_mid" id="x_mid" data-table="case_charges" data-field="x_mid" value="<?= $Page->mid->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->mid->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->mid->formatPattern()) ?>"<?= $Page->mid->editAttributes() ?> aria-describedby="x_mid_help">
<?= $Page->mid->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->mid->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->rank->Visible) { // rank ?>
    <div id="r_rank"<?= $Page->rank->rowAttributes() ?>>
        <label id="elh_case_charges_rank" for="x_rank" class="<?= $Page->LeftColumnClass ?>"><?= $Page->rank->caption() ?><?= $Page->rank->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->rank->cellAttributes() ?>>
<span id="el_case_charges_rank">
<input type="<?= $Page->rank->getInputTextType() ?>" name="x_rank" id="x_rank" data-table="case_charges" data-field="x_rank" value="<?= $Page->rank->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->rank->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->rank->formatPattern()) ?>"<?= $Page->rank->editAttributes() ?> aria-describedby="x_rank_help">
<?= $Page->rank->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->rank->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
    <div id="r_name"<?= $Page->name->rowAttributes() ?>>
        <label id="elh_case_charges_name" for="x_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->name->caption() ?><?= $Page->name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->name->cellAttributes() ?>>
<span id="el_case_charges_name">
<input type="<?= $Page->name->getInputTextType() ?>" name="x_name" id="x_name" data-table="case_charges" data-field="x_name" value="<?= $Page->name->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->name->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->name->formatPattern()) ?>"<?= $Page->name->editAttributes() ?> aria-describedby="x_name_help">
<?= $Page->name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->address->Visible) { // address ?>
    <div id="r_address"<?= $Page->address->rowAttributes() ?>>
        <label id="elh_case_charges_address" for="x_address" class="<?= $Page->LeftColumnClass ?>"><?= $Page->address->caption() ?><?= $Page->address->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->address->cellAttributes() ?>>
<span id="el_case_charges_address">
<input type="<?= $Page->address->getInputTextType() ?>" name="x_address" id="x_address" data-table="case_charges" data-field="x_address" value="<?= $Page->address->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->address->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->address->formatPattern()) ?>"<?= $Page->address->editAttributes() ?> aria-describedby="x_address_help">
<?= $Page->address->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->address->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->state->Visible) { // state ?>
    <div id="r_state"<?= $Page->state->rowAttributes() ?>>
        <label id="elh_case_charges_state" for="x_state" class="<?= $Page->LeftColumnClass ?>"><?= $Page->state->caption() ?><?= $Page->state->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->state->cellAttributes() ?>>
<span id="el_case_charges_state">
<input type="<?= $Page->state->getInputTextType() ?>" name="x_state" id="x_state" data-table="case_charges" data-field="x_state" value="<?= $Page->state->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->state->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->state->formatPattern()) ?>"<?= $Page->state->editAttributes() ?> aria-describedby="x_state_help">
<?= $Page->state->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->state->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->crimeDescription->Visible) { // crimeDescription ?>
    <div id="r_crimeDescription"<?= $Page->crimeDescription->rowAttributes() ?>>
        <label id="elh_case_charges_crimeDescription" for="x_crimeDescription" class="<?= $Page->LeftColumnClass ?>"><?= $Page->crimeDescription->caption() ?><?= $Page->crimeDescription->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->crimeDescription->cellAttributes() ?>>
<span id="el_case_charges_crimeDescription">
<textarea data-table="case_charges" data-field="x_crimeDescription" name="x_crimeDescription" id="x_crimeDescription" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->crimeDescription->getPlaceHolder()) ?>"<?= $Page->crimeDescription->editAttributes() ?> aria-describedby="x_crimeDescription_help"><?= $Page->crimeDescription->EditValue ?></textarea>
<?= $Page->crimeDescription->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->crimeDescription->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->crimeDate->Visible) { // crimeDate ?>
    <div id="r_crimeDate"<?= $Page->crimeDate->rowAttributes() ?>>
        <label id="elh_case_charges_crimeDate" for="x_crimeDate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->crimeDate->caption() ?><?= $Page->crimeDate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->crimeDate->cellAttributes() ?>>
<span id="el_case_charges_crimeDate">
<input type="<?= $Page->crimeDate->getInputTextType() ?>" name="x_crimeDate" id="x_crimeDate" data-table="case_charges" data-field="x_crimeDate" value="<?= $Page->crimeDate->EditValue ?>" placeholder="<?= HtmlEncode($Page->crimeDate->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->crimeDate->formatPattern()) ?>"<?= $Page->crimeDate->editAttributes() ?> aria-describedby="x_crimeDate_help">
<?= $Page->crimeDate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->crimeDate->getErrorMessage() ?></div>
<?php if (!$Page->crimeDate->ReadOnly && !$Page->crimeDate->Disabled && !isset($Page->crimeDate->EditAttrs["readonly"]) && !isset($Page->crimeDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fcase_chargesadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fcase_chargesadd", "x_crimeDate", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ChargeDate->Visible) { // ChargeDate ?>
    <div id="r_ChargeDate"<?= $Page->ChargeDate->rowAttributes() ?>>
        <label id="elh_case_charges_ChargeDate" for="x_ChargeDate" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ChargeDate->caption() ?><?= $Page->ChargeDate->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ChargeDate->cellAttributes() ?>>
<span id="el_case_charges_ChargeDate">
<input type="<?= $Page->ChargeDate->getInputTextType() ?>" name="x_ChargeDate" id="x_ChargeDate" data-table="case_charges" data-field="x_ChargeDate" value="<?= $Page->ChargeDate->EditValue ?>" placeholder="<?= HtmlEncode($Page->ChargeDate->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->ChargeDate->formatPattern()) ?>"<?= $Page->ChargeDate->editAttributes() ?> aria-describedby="x_ChargeDate_help">
<?= $Page->ChargeDate->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ChargeDate->getErrorMessage() ?></div>
<?php if (!$Page->ChargeDate->ReadOnly && !$Page->ChargeDate->Disabled && !isset($Page->ChargeDate->EditAttrs["readonly"]) && !isset($Page->ChargeDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fcase_chargesadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fcase_chargesadd", "x_ChargeDate", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <div id="r_created_at"<?= $Page->created_at->rowAttributes() ?>>
        <label id="elh_case_charges_created_at" for="x_created_at" class="<?= $Page->LeftColumnClass ?>"><?= $Page->created_at->caption() ?><?= $Page->created_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->created_at->cellAttributes() ?>>
<span id="el_case_charges_created_at">
<input type="<?= $Page->created_at->getInputTextType() ?>" name="x_created_at" id="x_created_at" data-table="case_charges" data-field="x_created_at" value="<?= $Page->created_at->EditValue ?>" placeholder="<?= HtmlEncode($Page->created_at->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->created_at->formatPattern()) ?>"<?= $Page->created_at->editAttributes() ?> aria-describedby="x_created_at_help">
<?= $Page->created_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->created_at->getErrorMessage() ?></div>
<?php if (!$Page->created_at->ReadOnly && !$Page->created_at->Disabled && !isset($Page->created_at->EditAttrs["readonly"]) && !isset($Page->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fcase_chargesadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fcase_chargesadd", "x_created_at", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
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
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fcase_chargesadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fcase_chargesadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("case_charges");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
