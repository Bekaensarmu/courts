<?php

namespace PHPMaker2024\project2;

// Page object
$SpecialfilesAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { specialfiles: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fspecialfilesadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fspecialfilesadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["_12D512DD", [fields._12D512DD.visible && fields._12D512DD.required ? ew.Validators.required(fields._12D512DD.caption) : null], fields._12D512DD.isInvalid],
            ["_12E8127D120E12751235121D", [fields._12E8127D120E12751235121D.visible && fields._12E8127D120E12751235121D.required ? ew.Validators.required(fields._12E8127D120E12751235121D.caption) : null], fields._12E8127D120E12751235121D.isInvalid],
            ["_12E812AD122D12AD1229120212F01275", [fields._12E812AD122D12AD1229120212F01275.visible && fields._12E812AD122D12AD1229120212F01275.required ? ew.Validators.required(fields._12E812AD122D12AD1229120212F01275.caption) : null], fields._12E812AD122D12AD1229120212F01275.isInvalid],
            ["_12E812AD123512D312ED12901275", [fields._12E812AD123512D312ED12901275.visible && fields._12E812AD123512D312ED12901275.required ? ew.Validators.required(fields._12E812AD123512D312ED12901275.caption) : null], fields._12E812AD123512D312ED12901275.isInvalid],
            ["_12E812401320122E121D12AD129512EB1275", [fields._12E812401320122E121D12AD129512EB1275.visible && fields._12E812401320122E121D12AD129512EB1275.required ? ew.Validators.required(fields._12E812401320122E121D12AD129512EB1275.caption) : null], fields._12E812401320122E121D12AD129512EB1275.isInvalid],
            ["_12E812CD1233129412D312ED12901275", [fields._12E812CD1233129412D312ED12901275.visible && fields._12E812CD1233129412D312ED12901275.required ? ew.Validators.required(fields._12E812CD1233129412D312ED12901275.caption) : null], fields._12E812CD1233129412D312ED12901275.isInvalid],
            ["_121B12D51228130D", [fields._121B12D51228130D.visible && fields._121B12D51228130D.required ? ew.Validators.required(fields._121B12D51228130D.caption) : null], fields._121B12D51228130D.isInvalid],
            ["_121B1265122B122D12EB", [fields._121B1265122B122D12EB.visible && fields._121B1265122B122D12EB.required ? ew.Validators.required(fields._121B1265122B122D12EB.caption) : null], fields._121B1265122B122D12EB.isInvalid],
            ["_12E81270121812D8130812601260127512401295", [fields._12E81270121812D8130812601260127512401295.visible && fields._12E81270121812D8130812601260127512401295.required ? ew.Validators.required(fields._12E81270121812D8130812601260127512401295.caption) : null, ew.Validators.datetime(fields._12E81270121812D8130812601260127512401295.clientFormatPattern)], fields._12E81270121812D8130812601260127512401295.isInvalid]
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
<form name="fspecialfilesadd" id="fspecialfilesadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="specialfiles">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->_12D512DD->Visible) { // ዕዝ ?>
    <div id="r__12D512DD"<?= $Page->_12D512DD->rowAttributes() ?>>
        <label id="elh_specialfiles__12D512DD" for="x__12D512DD" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_12D512DD->caption() ?><?= $Page->_12D512DD->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_12D512DD->cellAttributes() ?>>
<span id="el_specialfiles__12D512DD">
<input type="<?= $Page->_12D512DD->getInputTextType() ?>" name="x__12D512DD" id="x__12D512DD" data-table="specialfiles" data-field="x__12D512DD" value="<?= $Page->_12D512DD->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_12D512DD->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_12D512DD->formatPattern()) ?>"<?= $Page->_12D512DD->editAttributes() ?> aria-describedby="x__12D512DD_help">
<?= $Page->_12D512DD->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_12D512DD->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_12E8127D120E12751235121D->Visible) { // የችሎትስም ?>
    <div id="r__12E8127D120E12751235121D"<?= $Page->_12E8127D120E12751235121D->rowAttributes() ?>>
        <label id="elh_specialfiles__12E8127D120E12751235121D" for="x__12E8127D120E12751235121D" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_12E8127D120E12751235121D->caption() ?><?= $Page->_12E8127D120E12751235121D->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_12E8127D120E12751235121D->cellAttributes() ?>>
<span id="el_specialfiles__12E8127D120E12751235121D">
<input type="<?= $Page->_12E8127D120E12751235121D->getInputTextType() ?>" name="x__12E8127D120E12751235121D" id="x__12E8127D120E12751235121D" data-table="specialfiles" data-field="x__12E8127D120E12751235121D" value="<?= $Page->_12E8127D120E12751235121D->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_12E8127D120E12751235121D->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_12E8127D120E12751235121D->formatPattern()) ?>"<?= $Page->_12E8127D120E12751235121D->editAttributes() ?> aria-describedby="x__12E8127D120E12751235121D_help">
<?= $Page->_12E8127D120E12751235121D->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_12E8127D120E12751235121D->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_12E812AD122D12AD1229120212F01275->Visible) { // የክርክሩሂደት ?>
    <div id="r__12E812AD122D12AD1229120212F01275"<?= $Page->_12E812AD122D12AD1229120212F01275->rowAttributes() ?>>
        <label id="elh_specialfiles__12E812AD122D12AD1229120212F01275" for="x__12E812AD122D12AD1229120212F01275" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_12E812AD122D12AD1229120212F01275->caption() ?><?= $Page->_12E812AD122D12AD1229120212F01275->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_12E812AD122D12AD1229120212F01275->cellAttributes() ?>>
<span id="el_specialfiles__12E812AD122D12AD1229120212F01275">
<input type="<?= $Page->_12E812AD122D12AD1229120212F01275->getInputTextType() ?>" name="x__12E812AD122D12AD1229120212F01275" id="x__12E812AD122D12AD1229120212F01275" data-table="specialfiles" data-field="x__12E812AD122D12AD1229120212F01275" value="<?= $Page->_12E812AD122D12AD1229120212F01275->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_12E812AD122D12AD1229120212F01275->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_12E812AD122D12AD1229120212F01275->formatPattern()) ?>"<?= $Page->_12E812AD122D12AD1229120212F01275->editAttributes() ?> aria-describedby="x__12E812AD122D12AD1229120212F01275_help">
<?= $Page->_12E812AD122D12AD1229120212F01275->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_12E812AD122D12AD1229120212F01275->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_12E812AD123512D312ED12901275->Visible) { // የክስዓይነት ?>
    <div id="r__12E812AD123512D312ED12901275"<?= $Page->_12E812AD123512D312ED12901275->rowAttributes() ?>>
        <label id="elh_specialfiles__12E812AD123512D312ED12901275" for="x__12E812AD123512D312ED12901275" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_12E812AD123512D312ED12901275->caption() ?><?= $Page->_12E812AD123512D312ED12901275->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_12E812AD123512D312ED12901275->cellAttributes() ?>>
<span id="el_specialfiles__12E812AD123512D312ED12901275">
<input type="<?= $Page->_12E812AD123512D312ED12901275->getInputTextType() ?>" name="x__12E812AD123512D312ED12901275" id="x__12E812AD123512D312ED12901275" data-table="specialfiles" data-field="x__12E812AD123512D312ED12901275" value="<?= $Page->_12E812AD123512D312ED12901275->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_12E812AD123512D312ED12901275->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_12E812AD123512D312ED12901275->formatPattern()) ?>"<?= $Page->_12E812AD123512D312ED12901275->editAttributes() ?> aria-describedby="x__12E812AD123512D312ED12901275_help">
<?= $Page->_12E812AD123512D312ED12901275->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_12E812AD123512D312ED12901275->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_12E812401320122E121D12AD129512EB1275->Visible) { // የቀጠሮምክንያት ?>
    <div id="r__12E812401320122E121D12AD129512EB1275"<?= $Page->_12E812401320122E121D12AD129512EB1275->rowAttributes() ?>>
        <label id="elh_specialfiles__12E812401320122E121D12AD129512EB1275" for="x__12E812401320122E121D12AD129512EB1275" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_12E812401320122E121D12AD129512EB1275->caption() ?><?= $Page->_12E812401320122E121D12AD129512EB1275->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_12E812401320122E121D12AD129512EB1275->cellAttributes() ?>>
<span id="el_specialfiles__12E812401320122E121D12AD129512EB1275">
<input type="<?= $Page->_12E812401320122E121D12AD129512EB1275->getInputTextType() ?>" name="x__12E812401320122E121D12AD129512EB1275" id="x__12E812401320122E121D12AD129512EB1275" data-table="specialfiles" data-field="x__12E812401320122E121D12AD129512EB1275" value="<?= $Page->_12E812401320122E121D12AD129512EB1275->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_12E812401320122E121D12AD129512EB1275->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_12E812401320122E121D12AD129512EB1275->formatPattern()) ?>"<?= $Page->_12E812401320122E121D12AD129512EB1275->editAttributes() ?> aria-describedby="x__12E812401320122E121D12AD129512EB1275_help">
<?= $Page->_12E812401320122E121D12AD129512EB1275->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_12E812401320122E121D12AD129512EB1275->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_12E812CD1233129412D312ED12901275->Visible) { // የውሳኔዓይነት ?>
    <div id="r__12E812CD1233129412D312ED12901275"<?= $Page->_12E812CD1233129412D312ED12901275->rowAttributes() ?>>
        <label id="elh_specialfiles__12E812CD1233129412D312ED12901275" for="x__12E812CD1233129412D312ED12901275" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_12E812CD1233129412D312ED12901275->caption() ?><?= $Page->_12E812CD1233129412D312ED12901275->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_12E812CD1233129412D312ED12901275->cellAttributes() ?>>
<span id="el_specialfiles__12E812CD1233129412D312ED12901275">
<input type="<?= $Page->_12E812CD1233129412D312ED12901275->getInputTextType() ?>" name="x__12E812CD1233129412D312ED12901275" id="x__12E812CD1233129412D312ED12901275" data-table="specialfiles" data-field="x__12E812CD1233129412D312ED12901275" value="<?= $Page->_12E812CD1233129412D312ED12901275->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_12E812CD1233129412D312ED12901275->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_12E812CD1233129412D312ED12901275->formatPattern()) ?>"<?= $Page->_12E812CD1233129412D312ED12901275->editAttributes() ?> aria-describedby="x__12E812CD1233129412D312ED12901275_help">
<?= $Page->_12E812CD1233129412D312ED12901275->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_12E812CD1233129412D312ED12901275->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_121B12D51228130D->Visible) { // ማዕረግ ?>
    <div id="r__121B12D51228130D"<?= $Page->_121B12D51228130D->rowAttributes() ?>>
        <label id="elh_specialfiles__121B12D51228130D" for="x__121B12D51228130D" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_121B12D51228130D->caption() ?><?= $Page->_121B12D51228130D->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_121B12D51228130D->cellAttributes() ?>>
<span id="el_specialfiles__121B12D51228130D">
<input type="<?= $Page->_121B12D51228130D->getInputTextType() ?>" name="x__121B12D51228130D" id="x__121B12D51228130D" data-table="specialfiles" data-field="x__121B12D51228130D" value="<?= $Page->_121B12D51228130D->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_121B12D51228130D->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_121B12D51228130D->formatPattern()) ?>"<?= $Page->_121B12D51228130D->editAttributes() ?> aria-describedby="x__121B12D51228130D_help">
<?= $Page->_121B12D51228130D->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_121B12D51228130D->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_121B1265122B122D12EB->Visible) { // ማብራርያ ?>
    <div id="r__121B1265122B122D12EB"<?= $Page->_121B1265122B122D12EB->rowAttributes() ?>>
        <label id="elh_specialfiles__121B1265122B122D12EB" for="x__121B1265122B122D12EB" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_121B1265122B122D12EB->caption() ?><?= $Page->_121B1265122B122D12EB->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_121B1265122B122D12EB->cellAttributes() ?>>
<span id="el_specialfiles__121B1265122B122D12EB">
<input type="<?= $Page->_121B1265122B122D12EB->getInputTextType() ?>" name="x__121B1265122B122D12EB" id="x__121B1265122B122D12EB" data-table="specialfiles" data-field="x__121B1265122B122D12EB" value="<?= $Page->_121B1265122B122D12EB->EditValue ?>" size="30" maxlength="65535" placeholder="<?= HtmlEncode($Page->_121B1265122B122D12EB->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_121B1265122B122D12EB->formatPattern()) ?>"<?= $Page->_121B1265122B122D12EB->editAttributes() ?> aria-describedby="x__121B1265122B122D12EB_help">
<?= $Page->_121B1265122B122D12EB->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_121B1265122B122D12EB->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_12E81270121812D8130812601260127512401295->Visible) { // የተመዘገበበትቀን ?>
    <div id="r__12E81270121812D8130812601260127512401295"<?= $Page->_12E81270121812D8130812601260127512401295->rowAttributes() ?>>
        <label id="elh_specialfiles__12E81270121812D8130812601260127512401295" for="x__12E81270121812D8130812601260127512401295" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_12E81270121812D8130812601260127512401295->caption() ?><?= $Page->_12E81270121812D8130812601260127512401295->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_12E81270121812D8130812601260127512401295->cellAttributes() ?>>
<span id="el_specialfiles__12E81270121812D8130812601260127512401295">
<input type="<?= $Page->_12E81270121812D8130812601260127512401295->getInputTextType() ?>" name="x__12E81270121812D8130812601260127512401295" id="x__12E81270121812D8130812601260127512401295" data-table="specialfiles" data-field="x__12E81270121812D8130812601260127512401295" value="<?= $Page->_12E81270121812D8130812601260127512401295->EditValue ?>" placeholder="<?= HtmlEncode($Page->_12E81270121812D8130812601260127512401295->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_12E81270121812D8130812601260127512401295->formatPattern()) ?>"<?= $Page->_12E81270121812D8130812601260127512401295->editAttributes() ?> aria-describedby="x__12E81270121812D8130812601260127512401295_help">
<?= $Page->_12E81270121812D8130812601260127512401295->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_12E81270121812D8130812601260127512401295->getErrorMessage() ?></div>
<?php if (!$Page->_12E81270121812D8130812601260127512401295->ReadOnly && !$Page->_12E81270121812D8130812601260127512401295->Disabled && !isset($Page->_12E81270121812D8130812601260127512401295->EditAttrs["readonly"]) && !isset($Page->_12E81270121812D8130812601260127512401295->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fspecialfilesadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fspecialfilesadd", "x__12E81270121812D8130812601260127512401295", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
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
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fspecialfilesadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fspecialfilesadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("specialfiles");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
