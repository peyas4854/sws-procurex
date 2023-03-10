<?php

namespace App\Traits;

trait MailMessage
{
    public function sendToCostCenterHead($requisition)
    {
        $url = route('requisitions.show', $requisition->id);
        return [
            "subject" => "A Requisition request is waiting for your approval : $requisition->requisition_code",
            "type" => "$requisition->item_type",
            "requisition_id" => "$requisition->id",
            "mail_subject" => "Requisition Approval($requisition->requisition_code)",
            "url" => $url,
            "application_date" => $requisition->application_date,
            "salutation" => "Dear concern",
            "required_date" => $requisition->required_date,
            "introduction" => "A requisition request for approval against reference no $requisition->requisition_code
             has arrived for your approval. Please see the below details:",
            "body" => view("mail-template.requisitions.business-head", compact("requisition"))->render(),
            "closing" => "Please visit <a href='$url' target='_blank'>(Link of Approval Status)</a>" . " to approve the request.."
        ];
    }

    public function sendToUser($requisition)
    {
        $url = route('requisitions.show', $requisition->id);
        return [
            "subject" => "Your following requisition $requisition->requisition_code , $requisition->status form approval team",
            "type" => "$requisition->item_type",
            "requisition_id" => "$requisition->id",
            "mail_subject" => "Requisition ($requisition->requisition_code)",
            "url" => $url,
            "application_date" => $requisition->application_date,
            "salutation" => "Dear concern",
            "required_date" => $requisition->required_date,
            "introduction" => "Your Requisition $requisition->requisition_code have been  $requisition->status, Please see the below details:",
            "closing" => "Please visit <a href='$url' target='_blank'>(Link of Approval Status)</a>" . " to approve the request.."
        ];
    }

    public function procurementTeamMessage($requisition)
    {

        $url = route('requisitions.show', $requisition->id);
        return [
            "subject" => "Your following requisition $requisition->requisition_code , $requisition->status form approval team",
            "type" => "$requisition->item_type",
            "requisition_id" => "$requisition->id",
            "mail_subject" => "Requisition ($requisition->requisition_code)",
            "url" => $url,
            "application_date" => $requisition->application_date,
            "salutation" => "Dear concern",
            "required_date" => $requisition->required_date,
            "introduction" => "A purchase requisition with ref: <b>$requisition->requisition_code </b> have been approved by all authorities.",
            "closing" => "Please visit <a href='$url' target='_blank'>(Link of PR)</a>" . " to find the approvals log."
        ];
    }

    public function csDetailMessage($csDetail)
    {
        $url = url('cs-detail', $csDetail->id);
        return [
            "subject" => "A CS request is waiting for your approval : $csDetail->cs_number",
            "mail_subject" => "CS Approval($csDetail->cs_number)",
            "url" => $url,
            "cs_detail_id" => $csDetail->id,
            "salutation" => "Dear concern",
            "introduction" => "A CS request for approval against reference no $csDetail->cs_number
             has arrived for your approval at Layer – 1. Please see the below details:",
            "body" => view("mail-template.cs-detail.cs-detail-approval", compact("csDetail"))->render(),
            "closing" => "Please visit <a href='$url' target='_blank'>(Link of Approval Status)</a>" . " to approve the request.."
        ];
    }

    public function CsDetailResponseMesageforUser($csDetail)
    {
        $url = url('cs-detail', $csDetail->id);
        return [
            "subject" => "Your following Cs Detail $csDetail->cs_number , have been $csDetail->status",
            "mail_subject" => "Cs Details Status($csDetail->cs_number)",
            "url" => $url,
            "cs_detail_id" => $csDetail->id,
            "salutation" => "Dear concern",
            "introduction" => "Your Cs Detail have been  $csDetail->status, Please see the below details:",
            "closing" => "Please visit <a href='$url' target='_blank'>(Link of Approval Status)</a>" . " to approve the request.."
        ];
    }

    public function purchaseOrderApprovalMessage($purchaseOrder)
    {
        $url = route('purchase-orders.show', $purchaseOrder->id);
        return [
            "subject" => "A purchase order request is waiting for your approval : $purchaseOrder->po_code",
            "mail_subject" => "Purchase Order Approval($purchaseOrder->po_code)",
            "url" => $url,
            "purchase_order_id" => $purchaseOrder->id,
            "salutation" => "Dear concern",
            "introduction" => "A purchase order request for approval against reference no $purchaseOrder->pr_code
             has arrived for your approval. Please see the below details:",
            "body" => view("mail-template.purchase-order.approval", compact("purchaseOrder"))->render(),
            "closing" => "Please visit <a href='$url' target='_blank'>(Link of Approval Status)</a>" . " to approve the request.."
        ];

    }
    public function purchaseOrderResponseMesageforUser($purchaseOrder)
    {
        $url = route('purchase-orders.show', $purchaseOrder->id);
        return [
            "subject" => "Your following purchase order $purchaseOrder->po_code , have been $purchaseOrder->status",
            "mail_subject" => "Purchase order Status($purchaseOrder->po_code)",
            "url" => $url,
            "salutation" => "Dear concern",
            "introduction" => "Your purchase order have been  $purchaseOrder->status, Please see the below details:",
            "closing" => "Please visit <a href='$url' target='_blank'>(Link of Approval Status)</a>" . " to approve the request.."
        ];
    }
    public function reminderEmail($data)
    {
        return [
            "subject" => "Reminder",
            "mail_subject" => "Reminder Mail",
            "salutation" => "Dear concern",
            "body" => view("mail-template.reminder-email.reminder",compact(['data']))->render(),
            "closing" => "Please visit <a href='' target='_blank'>(Application Link)</a>" . " Application.."
        ];
    }

}
