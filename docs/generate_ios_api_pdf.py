"""
Generate detailed iOS API documentation PDF for Asmi Shop backend.

Features:
- Clickable Table of Contents (jumps to section)
- PDF outline / bookmarks (sidebar nav)
- Per-endpoint anchors
- Sample requests (cURL), sample responses, validation rules
- Swift snippets for auth, networking, multipart upload
- Resource shapes appendix with realistic example values

Output: docs/Asmi_Shop_iOS_API_Documentation.pdf
"""

from reportlab.lib import colors
from reportlab.lib.pagesizes import A4
from reportlab.lib.styles import getSampleStyleSheet, ParagraphStyle
from reportlab.lib.units import cm
from reportlab.lib.enums import TA_LEFT, TA_CENTER, TA_JUSTIFY
from reportlab.platypus import (
    BaseDocTemplate, PageTemplate, Frame,
    Paragraph, Spacer, PageBreak, Table, TableStyle,
    KeepTogether, ListFlowable, ListItem, Flowable,
)

OUTPUT = r"G:\asmi_shop\asmi_shop_backend\docs\Asmi_Shop_iOS_API_Documentation.pdf"

# ---------- Styles ----------
styles = getSampleStyleSheet()

TITLE = ParagraphStyle(
    'TitleBig', parent=styles['Title'], fontSize=30, leading=36,
    alignment=TA_CENTER, textColor=colors.HexColor('#1a3a6c'), spaceAfter=14
)
SUBTITLE = ParagraphStyle(
    'SubTitle', parent=styles['Normal'], fontSize=13, leading=17,
    alignment=TA_CENTER, textColor=colors.HexColor('#555555'), spaceAfter=6
)
H1 = ParagraphStyle(
    'H1', parent=styles['Heading1'], fontSize=20, leading=24,
    textColor=colors.HexColor('#1a3a6c'), spaceBefore=18, spaceAfter=10,
    keepWithNext=True
)
H2 = ParagraphStyle(
    'H2', parent=styles['Heading2'], fontSize=15, leading=18,
    textColor=colors.HexColor('#264f8c'), spaceBefore=14, spaceAfter=6,
    keepWithNext=True
)
H3 = ParagraphStyle(
    'H3', parent=styles['Heading3'], fontSize=12, leading=15,
    textColor=colors.HexColor('#333333'), spaceBefore=10, spaceAfter=4,
    keepWithNext=True
)
H4 = ParagraphStyle(
    'H4', parent=styles['Heading4'], fontSize=10.5, leading=13,
    textColor=colors.HexColor('#444444'), spaceBefore=8, spaceAfter=3,
    keepWithNext=True
)
BODY = ParagraphStyle(
    'Body', parent=styles['BodyText'], fontSize=10, leading=14,
    alignment=TA_JUSTIFY, spaceAfter=6
)
SMALL = ParagraphStyle(
    'Small', parent=styles['BodyText'], fontSize=9, leading=12, spaceAfter=3
)
TINY = ParagraphStyle(
    'Tiny', parent=styles['BodyText'], fontSize=8, leading=10, spaceAfter=2
)
CODE = ParagraphStyle(
    'Code', parent=styles['Code'], fontSize=8.5, leading=11,
    backColor=colors.HexColor('#f4f6fa'), borderPadding=6,
    leftIndent=4, rightIndent=4, spaceBefore=4, spaceAfter=8,
    textColor=colors.HexColor('#1f2d3d'),
    borderColor=colors.HexColor('#dfe5ee'), borderWidth=0.4
)
CODE_DARK = ParagraphStyle(
    'CodeDark', parent=CODE,
    backColor=colors.HexColor('#1f2d3d'),
    textColor=colors.HexColor('#e6edf6'),
    borderColor=colors.HexColor('#1f2d3d')
)
ENDPOINT = ParagraphStyle(
    'Endpoint', parent=styles['Heading4'], fontSize=11, leading=14,
    textColor=colors.HexColor('#0d6b3a'), spaceBefore=12, spaceAfter=2,
    fontName='Courier-Bold', keepWithNext=True
)
NOTE = ParagraphStyle(
    'Note', parent=styles['BodyText'], fontSize=9, leading=12,
    backColor=colors.HexColor('#fff4d6'), borderPadding=6,
    leftIndent=2, rightIndent=2, spaceBefore=4, spaceAfter=8,
    borderColor=colors.HexColor('#ecd58a'), borderWidth=0.4,
    textColor=colors.HexColor('#5a4500')
)
DANGER = ParagraphStyle(
    'Danger', parent=styles['BodyText'], fontSize=9, leading=12,
    backColor=colors.HexColor('#fde2e1'), borderPadding=6,
    leftIndent=2, rightIndent=2, spaceBefore=4, spaceAfter=8,
    borderColor=colors.HexColor('#e5a6a3'), borderWidth=0.4,
    textColor=colors.HexColor('#7a1c19')
)
TOC_L1 = ParagraphStyle('TocL1', parent=styles['BodyText'], fontSize=11, leading=15, spaceAfter=2,
                       textColor=colors.HexColor('#1a3a6c'))
TOC_L2 = ParagraphStyle('TocL2', parent=styles['BodyText'], fontSize=10, leading=13, spaceAfter=1,
                       leftIndent=14, textColor=colors.HexColor('#1a3a6c'))
TOC_L3 = ParagraphStyle('TocL3', parent=styles['BodyText'], fontSize=9.5, leading=12, spaceAfter=0,
                       leftIndent=28, textColor=colors.HexColor('#444444'))


# ---------- Custom flowable: bookmark + outline entry ----------

class Anchor(Flowable):
    """Invisible flowable that places a bookmark (always) + outline entry (when level is not None)."""
    def __init__(self, key, label, level=None):
        super().__init__()
        self.key = key
        self.label = label
        self.level = level

    def wrap(self, _w, _h):
        return 0, 0

    def draw(self):
        c = self.canv
        c.bookmarkPage(self.key)
        if self.level is not None:
            c.addOutlineEntry(self.label, self.key, self.level, 0)


# ---------- Helpers ----------

def esc(s):
    return (s.replace('&', '&amp;').replace('<', '&lt;').replace('>', '&gt;'))


def code_block(text, dark=False):
    safe = esc(text).replace('\n', '<br/>').replace(' ', '&nbsp;')
    return Paragraph(f'<font face="Courier" size="8.5">{safe}</font>', CODE_DARK if dark else CODE)


def heading(text, style, anchor=None, label=None, outline_level=0):
    """Heading with bookmark + outline entry."""
    flowables = []
    if anchor:
        flowables.append(Anchor(anchor, label or text, outline_level))
    flowables.append(Paragraph(text, style))
    return KeepTogether(flowables)


def toc_link(text, anchor, style=TOC_L1, leader_text=''):
    safe_anchor = anchor.replace(' ', '_')
    label = (esc(text) + (f' &middot; {leader_text}' if leader_text else ''))
    return Paragraph(f'<link href="#{safe_anchor}" color="#1a3a6c">{label}</link>', style)


def kv_table(rows, col_widths=None):
    cw = col_widths or [4.5 * cm, 12.5 * cm]
    data = [[Paragraph(f'<b>{esc(k)}</b>', SMALL), Paragraph(v, SMALL)] for k, v in rows]
    t = Table(data, colWidths=cw, hAlign='LEFT')
    t.setStyle(TableStyle([
        ('GRID', (0, 0), (-1, -1), 0.4, colors.HexColor('#cfd8e3')),
        ('BACKGROUND', (0, 0), (0, -1), colors.HexColor('#f4f6fa')),
        ('VALIGN', (0, 0), (-1, -1), 'TOP'),
        ('LEFTPADDING', (0, 0), (-1, -1), 6),
        ('RIGHTPADDING', (0, 0), (-1, -1), 6),
        ('TOPPADDING', (0, 0), (-1, -1), 4),
        ('BOTTOMPADDING', (0, 0), (-1, -1), 4),
    ]))
    return t


def params_table(rows):
    """rows = list of (name, type, required, description)"""
    header = [Paragraph(f'<b>{h}</b>', SMALL) for h in ('Param', 'Type', 'Required', 'Description')]
    body = [[Paragraph(f'<font face="Courier">{esc(r[0])}</font>', SMALL),
             Paragraph(esc(r[1]), SMALL),
             Paragraph(esc(r[2]), SMALL),
             Paragraph(r[3], SMALL)] for r in rows]
    t = Table([header] + body, colWidths=[4 * cm, 3 * cm, 2 * cm, 8 * cm], hAlign='LEFT', repeatRows=1)
    t.setStyle(TableStyle([
        ('GRID', (0, 0), (-1, -1), 0.4, colors.HexColor('#cfd8e3')),
        ('BACKGROUND', (0, 0), (-1, 0), colors.HexColor('#1a3a6c')),
        ('TEXTCOLOR', (0, 0), (-1, 0), colors.white),
        ('VALIGN', (0, 0), (-1, -1), 'TOP'),
        ('LEFTPADDING', (0, 0), (-1, -1), 5),
        ('RIGHTPADDING', (0, 0), (-1, -1), 5),
        ('TOPPADDING', (0, 0), (-1, -1), 4),
        ('BOTTOMPADDING', (0, 0), (-1, -1), 4),
    ]))
    return t


def endpoint(method, path, auth=False, anchor=None):
    flowables = []
    if anchor:
        flowables.append(Anchor(anchor, f'{method} {path}'))
    badge = '<font color="#b54708"><b>[AUTH]</b></font> ' if auth else ''
    flowables.append(Paragraph(
        f'{badge}<font color="#0d6b3a"><b>{method}</b></font> '
        f'<font face="Courier"><b>{esc(path)}</b></font>', ENDPOINT))
    return KeepTogether(flowables)


def note(text):
    return Paragraph(f'<b>Note.</b> {text}', NOTE)


def danger(text):
    return Paragraph(f'<b>Important.</b> {text}', DANGER)


# ---------- Doc template with footer + cover ----------

class APIDocTemplate(BaseDocTemplate):
    def __init__(self, filename, **kw):
        super().__init__(filename, pagesize=A4,
                        leftMargin=2 * cm, rightMargin=2 * cm,
                        topMargin=2 * cm, bottomMargin=2 * cm,
                        title="Asmi Shop iOS API Documentation",
                        author="Asmi Shop Backend Team",
                        subject="iOS integration reference for Asmi Shop REST API",
                        **kw)
        frame = Frame(self.leftMargin, self.bottomMargin,
                      self.width, self.height, id='main')
        self.addPageTemplates([
            PageTemplate(id='cover', frames=frame, onPage=self._cover_decoration),
            PageTemplate(id='content', frames=frame, onPage=self._page_footer),
        ])

    def _cover_decoration(self, canv, doc):
        canv.saveState()
        canv.setStrokeColor(colors.HexColor('#1a3a6c'))
        canv.setLineWidth(2)
        canv.rect(1.5 * cm, 1.5 * cm, A4[0] - 3 * cm, A4[1] - 3 * cm, stroke=1, fill=0)
        canv.restoreState()

    def _page_footer(self, canv, doc):
        canv.saveState()
        canv.setFont('Helvetica', 8)
        canv.setFillColor(colors.HexColor('#777777'))
        canv.drawString(2 * cm, 1.2 * cm, "Asmi Shop — iOS API Documentation")
        canv.drawRightString(A4[0] - 2 * cm, 1.2 * cm, f"Page {doc.page}")
        canv.restoreState()


# ============================================================================
# CONTENT
# ============================================================================

story = []

# --------------------------- COVER PAGE --------------------------------------
story.append(Spacer(1, 5 * cm))
story.append(Paragraph("Asmi Shop", TITLE))
story.append(Paragraph("API Documentation", TITLE))
story.append(Spacer(1, 0.8 * cm))
story.append(Paragraph("Backend: Laravel 8 / PHP 7.4+ &middot; Auth: JWT (tymon)", SUBTITLE))
story.append(Spacer(1, 2 * cm))
story.append(Paragraph(
    "<i>Audience: iOS engineers integrating Asmi Shop REST APIs. "
    "Covers Authentication, Public Frontend, User (authenticated), Checkout "
    "and Payment endpoints with full request/response shapes, sample cURL, "
    "Swift snippets and a resource appendix.</i>", SUBTITLE))
story.append(Spacer(1, 1.5 * cm))
story.append(Paragraph(
    "Tip: every entry in the Table of Contents is clickable. "
    "Use the bookmarks pane in your PDF reader for fast navigation.", SUBTITLE))
story.append(Spacer(1, 2.5 * cm))
story.append(Paragraph("Prepared by <b>Tahmid Alavi Ishmam</b>", SUBTITLE))
story.append(PageBreak())

# --------------------------- TABLE OF CONTENTS -------------------------------
story.append(heading("Table of Contents", H1, anchor='toc', label='Table of Contents', outline_level=0))

TOC = [
    ('1. Overview &amp; Conventions',                  'sec_1', TOC_L1),
    ('1.1 Base URL &amp; environments',                'sec_1_1', TOC_L2),
    ('1.2 Authentication (JWT)',                       'sec_1_2', TOC_L2),
    ('1.3 Standard response envelope',                 'sec_1_3', TOC_L2),
    ('1.4 Error handling',                             'sec_1_4', TOC_L2),
    ('1.5 Common headers',                             'sec_1_5', TOC_L2),
    ('1.6 File uploads (multipart/form-data)',         'sec_1_6', TOC_L2),
    ('1.7 Pagination',                                 'sec_1_7', TOC_L2),
    ('1.8 Phone number format',                        'sec_1_8', TOC_L2),
    ('1.9 Image / asset URLs',                         'sec_1_9', TOC_L2),
    ('1.10 Currency &amp; price formatting',           'sec_1_10', TOC_L2),
    ('1.11 Localization',                              'sec_1_11', TOC_L2),
    ('1.12 Recommended Swift networking layer',        'sec_1_12', TOC_L2),

    ('2. Authentication endpoints',                    'sec_2', TOC_L1),
    ('2.1 POST /api/user/registration',                'ep_register', TOC_L2),
    ('2.2 POST /api/user/login',                       'ep_login', TOC_L2),
    ('2.3 POST /api/user/logout',                      'ep_logout', TOC_L2),
    ('2.4 POST /api/user/forgot',                      'ep_forgot', TOC_L2),
    ('2.5 POST /api/user/forgot/submit',               'ep_forgot_submit', TOC_L2),
    ('2.6 POST /api/user/social/login',                'ep_social', TOC_L2),
    ('2.7 GET /api/user/refresh/token',                'ep_refresh', TOC_L2),
    ('2.8 GET /api/user/details',                      'ep_details', TOC_L2),

    ('3. Public Frontend endpoints',                   'sec_3', TOC_L1),
    ('3.1 UI customization (sliders, banners, deals)', 'sec_3_1', TOC_L2),
    ('3.2 Settings, languages, currencies',            'sec_3_2', TOC_L2),
    ('3.3 Categories, attributes, search',             'sec_3_3', TOC_L2),
    ('3.4 Products &amp; deals',                       'sec_3_4', TOC_L2),
    ('3.5 Vendor / store',                             'sec_3_5', TOC_L2),
    ('3.6 Product details, ratings, comments',         'sec_3_6', TOC_L2),
    ('3.7 Checkout &amp; shipping',                    'sec_3_7', TOC_L2),
    ('3.8 FAQs, blogs, pages, contact, tracking',      'sec_3_8', TOC_L2),

    ('4. User endpoints (authenticated)',              'sec_4', TOC_L1),
    ('4.1 Dashboard &amp; profile',                    'sec_4_1', TOC_L2),
    ('4.2 Favorite vendors',                           'sec_4_2', TOC_L2),
    ('4.3 Wishlist',                                   'sec_4_3', TOC_L2),
    ('4.4 Orders',                                     'sec_4_4', TOC_L2),
    ('4.5 Reviews / comments / replies / reports',     'sec_4_5', TOC_L2),
    ('4.6 Messages (vendor)',                          'sec_4_6', TOC_L2),
    ('4.7 Tickets &amp; disputes',                     'sec_4_7', TOC_L2),
    ('4.8 Withdraw &amp; rewards',                     'sec_4_8', TOC_L2),
    ('4.9 Packages (vendor subscription)',             'sec_4_9', TOC_L2),
    ('4.10 Deposit &amp; transactions',                'sec_4_10', TOC_L2),

    ('5. Payment gateway endpoints',                   'sec_5', TOC_L1),
    ('6. Resource shapes (appendix)',                  'sec_6', TOC_L1),
    ('6.1 UserResource',                               'res_user', TOC_L2),
    ('6.2 ProductlistResource',                        'res_prodlist', TOC_L2),
    ('6.3 ProductDetailsResource',                     'res_proddetails', TOC_L2),
    ('6.4 OrderResource',                              'res_order', TOC_L2),
    ('6.5 OrderDetailsResource',                       'res_orderdetails', TOC_L2),
    ('6.6 OrderTrackResource',                         'res_ordertrack', TOC_L2),
    ('6.7 SliderResource / BannerResource',            'res_slider', TOC_L2),
    ('6.8 CategoryResource family',                    'res_category', TOC_L2),
    ('6.9 AttributeResource / AttributeOptionResource','res_attr', TOC_L2),
    ('6.10 RatingResource / CommentResource / ReplyResource', 'res_rating', TOC_L2),
    ('6.11 ConversationResource / Message',            'res_conv', TOC_L2),
    ('6.12 TicketDisputeResource / Message',           'res_ticket', TOC_L2),
    ('6.13 WithdrawDetailsResource',                   'res_withdraw', TOC_L2),
    ('6.14 PackageResource',                           'res_package', TOC_L2),
    ('6.15 ServiceResource / VendorResource',          'res_service', TOC_L2),
    ('6.16 FaqResource / BlogResource / PageResource', 'res_faq', TOC_L2),
    ('6.17 Featured links / banners / partners / gallery', 'res_featured', TOC_L2),
    ('6.18 SocialResource',                            'res_social', TOC_L2),
    ('6.19 ReportResource',                            'res_report', TOC_L2),

    ('7. Error reference',                             'sec_7', TOC_L1),
    ('8. iOS integration checklist',                   'sec_8', TOC_L1),
    ('9. Glossary',                                    'sec_9', TOC_L1),
]
for label, anchor, st in TOC:
    story.append(toc_link(label, anchor, style=st))
story.append(PageBreak())

# --------------------------- 1. OVERVIEW -------------------------------------
story.append(heading("1. Overview &amp; Conventions", H1, anchor='sec_1', label='1. Overview & Conventions'))
story.append(Paragraph(
    "Asmi Shop is a multi-vendor e-commerce backend on Laravel 8. "
    "All public-facing endpoints return JSON. "
    "Routes are mounted under the <font face='Courier'>/api</font> prefix. "
    "Authentication uses JSON Web Tokens (tymon/jwt-auth) with a "
    "<font face='Courier'>Bearer</font> scheme.",
    BODY))

# 1.1
story.append(heading("1.1 Base URL &amp; environments", H2, anchor='sec_1_1', label='1.1 Base URL & environments', outline_level=1))
story.append(Paragraph(
    "Replace <font face='Courier'>{host}</font> with the deployed hostname. "
    "There is no version prefix — the contract is the current branch. "
    "Stage and production share the same path layout; only the hostname differs.",
    BODY))
story.append(code_block(
    "Base URL : https://{host}/api\n\n"
    "Examples:\n"
    "  POST   https://api.asmishop.com/api/user/login\n"
    "  GET    https://api.asmishop.com/api/front/products?type=Physical&limit=20\n"
    "  GET    https://api.asmishop.com/api/user/dashboard   (Bearer token)\n"))

# 1.2
story.append(heading("1.2 Authentication (JWT)", H2, anchor='sec_1_2', label='1.2 Authentication (JWT)', outline_level=1))
story.append(Paragraph(
    "Successful registration / login / social-login returns a JWT in "
    "<font face='Courier'>data.token</font>. "
    "Pass it on every authenticated request:",
    BODY))
story.append(code_block("Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOi...<token>..."))
story.append(Paragraph(
    "Token TTL is reported as <font face='Courier'>expires_in</font> (seconds; default 3600 = 1 h). "
    "Use <font face='Courier'>GET /api/user/refresh/token</font> to get a new token before expiry. "
    "<font face='Courier'>POST /api/user/logout</font> invalidates the current token (server-side blacklist).",
    BODY))
story.append(note(
    "The <font face='Courier'>refresh/token</font> endpoint returns a flat JSON "
    "(<font face='Courier'>{access_token, token_type, expires_in}</font>) — <i>not</i> wrapped in "
    "the standard envelope. Do not assume the envelope universally."))

# 1.3
story.append(heading("1.3 Standard response envelope", H2, anchor='sec_1_3', label='1.3 Standard response envelope', outline_level=1))
story.append(Paragraph(
    "Almost all endpoints return:",
    BODY))
story.append(code_block(
    '{\n'
    '  "status": true,                       // bool — success / failure\n'
    '  "data":   { ... } | [ ... ] | null,   // payload\n'
    '  "error":  []                          // [] on success; object/string on failure\n'
    '}'))
story.append(Paragraph(
    "Decoding strategy: define a generic <font face='Courier'>APIResponse&lt;T: Decodable&gt;</font> and decode "
    "<font face='Courier'>data</font> into the endpoint-specific type once <font face='Courier'>status</font> is true.",
    BODY))
story.append(code_block(
    "// Swift\n"
    "struct APIResponse<T: Decodable>: Decodable {\n"
    "    let status: Bool\n"
    "    let data:   T?\n"
    "    let error:  APIError?\n"
    "}\n\n"
    "enum APIError: Decodable {\n"
    "    case message(String)\n"
    "    case fieldErrors([String: [String]])\n"
    "    case raw(String)\n\n"
    "    init(from decoder: Decoder) throws {\n"
    "        let c = try decoder.singleValueContainer()\n"
    "        if let s = try? c.decode(String.self) { self = .raw(s); return }\n"
    "        if let m = try? c.decode([String: String].self), let msg = m[\"message\"] {\n"
    "            self = .message(msg); return\n"
    "        }\n"
    "        if let fe = try? c.decode([String: [String]].self) { self = .fieldErrors(fe); return }\n"
    "        if let arr = try? c.decode([String].self), arr.isEmpty { self = .raw(\"\"); return }\n"
    "        self = .raw(\"unknown\")\n"
    "    }\n"
    "}", dark=True))

# 1.4
story.append(heading("1.4 Error handling", H2, anchor='sec_1_4', label='1.4 Error handling', outline_level=1))
story.append(Paragraph(
    "Three flavours of error you must decode:",
    BODY))
story.append(code_block(
    '// (a) Validation error — keys are field names, values are arrays of messages\n'
    '{ "status": false, "data": [], "error": { "phone": ["Phone is required."],\n'
    '                                            "password": ["Password is required."] } }\n\n'
    '// (b) Business error with message\n'
    '{ "status": false, "data": [], "error": { "message": "Email / password didn\'t match." } }\n\n'
    '// (c) Plain string error\n'
    '{ "status": false, "data": [], "error": "Account not found" }\n\n'
    '// (d) 404 fallback (only HTTP 404 case)\n'
    '{ "status": false, "data": [], "error": { "message": "Not Found!" } }'))
story.append(danger(
    "Most errors come back with HTTP <b>200</b>, not 4xx. "
    "<b>Always inspect the <font face='Courier'>status</font> flag</b> before treating a body as success. "
    "Some endpoints in older code paths even use <font face='Courier'>status: true</font> while reporting an error in "
    "<font face='Courier'>error.message</font> (legacy bug — defensive parsing recommended)."))

# 1.5
story.append(heading("1.5 Common headers", H2, anchor='sec_1_5', label='1.5 Common headers', outline_level=1))
story.append(kv_table([
    ('Accept', 'application/json'),
    ('Content-Type', 'application/json (or multipart/form-data on uploads)'),
    ('Authorization', 'Bearer &lt;jwt&gt; — required on /api/user/* (after the public auth subset)'),
    ('Accept-Language', 'Optional. Server may use this for localized strings.'),
    ('User-Agent', 'iOS app identifier (free-form; helps backend log analysis).'),
]))

# 1.6
story.append(heading("1.6 File uploads (multipart/form-data)", H2, anchor='sec_1_6', label='1.6 File uploads', outline_level=1))
story.append(Paragraph(
    "The only authenticated multipart endpoint is "
    "<font face='Courier'>POST /api/user/profile/update</font> with the "
    "<font face='Courier'>photo</font> field. Allowed types: jpeg, jpg, png, svg.",
    BODY))
story.append(code_block(
    "// Swift — URLSession multipart\n"
    "func multipartBody(boundary: String,\n"
    "                   fields: [String: String],\n"
    "                   fileField: String,\n"
    "                   fileName: String,\n"
    "                   fileData: Data,\n"
    "                   mimeType: String) -> Data {\n"
    "    var body = Data()\n"
    "    let line = \"\\r\\n\"\n"
    "    for (k, v) in fields {\n"
    "        body.append(\"--\\(boundary)\\(line)\".data(using: .utf8)!)\n"
    "        body.append(\"Content-Disposition: form-data; name=\\\"\\(k)\\\"\\(line)\\(line)\".data(using: .utf8)!)\n"
    "        body.append(\"\\(v)\\(line)\".data(using: .utf8)!)\n"
    "    }\n"
    "    body.append(\"--\\(boundary)\\(line)\".data(using: .utf8)!)\n"
    "    body.append(\"Content-Disposition: form-data; name=\\\"\\(fileField)\\\"; filename=\\\"\\(fileName)\\\"\\(line)\".data(using: .utf8)!)\n"
    "    body.append(\"Content-Type: \\(mimeType)\\(line)\\(line)\".data(using: .utf8)!)\n"
    "    body.append(fileData)\n"
    "    body.append(\"\\(line)--\\(boundary)--\\(line)\".data(using: .utf8)!)\n"
    "    return body\n"
    "}", dark=True))

# 1.7
story.append(heading("1.7 Pagination", H2, anchor='sec_1_7', label='1.7 Pagination', outline_level=1))
story.append(Paragraph(
    "Paginated endpoints accept <font face='Courier'>page</font> (1-indexed) and "
    "either <font face='Courier'>view</font> (orders), <font face='Courier'>paginate</font> (products), or "
    "<font face='Courier'>pageby</font> (offers) for page size. Response shape:",
    BODY))
story.append(code_block(
    '{\n'
    '  "status": true,\n'
    '  "data": {\n'
    '    "current_page": 1,\n'
    '    "last_page":    5,\n'
    '    "per_page":     12,\n'
    '    "total":        60,\n'
    '    "from":         1,\n'
    '    "to":           12,\n'
    '    "first_page_url": "...",\n'
    '    "last_page_url":  "...",\n'
    '    "next_page_url":  "...",\n'
    '    "prev_page_url":  null,\n'
    '    "path":           "...",\n'
    '    "data": [ ... items ... ]\n'
    '  },\n'
    '  "error": []\n'
    '}'))

# 1.8
story.append(heading("1.8 Phone number format", H2, anchor='sec_1_8', label='1.8 Phone number format', outline_level=1))
story.append(Paragraph(
    "Login validates <font face='Courier'>phone</font> against this regex (Bangladesh mobile). "
    "Mirror the rule in the iOS form so users see the error before a round-trip.",
    BODY))
story.append(code_block(
    "Regex     : ^(\\+8801[3-9][0-9]{8}|01[3-9][0-9]{8})$\n"
    "Valid     : 01712345678  /  +8801712345678\n"
    "Invalid   : 1712345678   /  017-1234-5678   /  +880712345678"))

# 1.9
story.append(heading("1.9 Image / asset URLs", H2, anchor='sec_1_9', label='1.9 Image / asset URLs', outline_level=1))
story.append(Paragraph(
    "Image fields in resources are returned <b>fully qualified</b> "
    "(<font face='Courier'>https://{host}/assets/images/...</font>). "
    "Do not concatenate the base URL again. Asset directories used by the API:",
    BODY))
story.append(kv_table([
    ('Sliders',          '/assets/images/sliders/'),
    ('Banners',          '/assets/images/banners/'),
    ('Categories',       '/assets/images/categories/'),
    ('Products',         '/assets/images/products/'),
    ('Thumbnails',       '/assets/images/thumbnails/'),
    ('Galleries',        '/assets/images/galleries/'),
    ('Users (avatar)',   '/assets/images/users/'),
    ('Vendor banner',    '/assets/images/vendorbanner/'),
    ('Services',         '/assets/images/services/'),
    ('Blogs',            '/assets/images/blogs/'),
    ('Partners',         '/assets/images/partner/'),
    ('Featured link',    '/assets/images/featuredlink/'),
    ('Featured banner',  '/assets/images/featuredbanner/'),
    ('Arrival',          '/assets/images/arrival/'),
    ('Default no image', '/assets/images/noimage.png'),
]))

# 1.10
story.append(heading("1.10 Currency &amp; price formatting", H2, anchor='sec_1_10', label='1.10 Currency & price formatting', outline_level=1))
story.append(Paragraph(
    "Product list / details return <font face='Courier'>current_price</font> and "
    "<font face='Courier'>previous_price</font> as <i>strings</i> already converted to the active currency "
    "(server multiplies by <font face='Courier'>currency.value</font>). Combine with "
    "<font face='Courier'>currency.symbol</font> + <font face='Courier'>currency.sign</font> "
    "(<font face='Courier'>left</font> / <font face='Courier'>right</font>) for display:",
    BODY))
story.append(code_block(
    "// pseudo\n"
    "let display = (currency.sign == \"left\")\n"
    "    ? \"\\(currency.symbol)\\(product.current_price)\"\n"
    "    : \"\\(product.current_price)\\(currency.symbol)\"", dark=True))
story.append(Paragraph(
    "Fetch and cache <font face='Courier'>GET /api/front/default/currency</font> at app launch. "
    "Allow override via <font face='Courier'>GET /api/front/currencies</font> + <font face='Courier'>currency/{id}</font>.",
    BODY))

# 1.11
story.append(heading("1.11 Localization", H2, anchor='sec_1_11', label='1.11 Localization', outline_level=1))
story.append(Paragraph(
    "Server holds translation bundles per language: "
    "<font face='Courier'>GET /api/front/languages</font> lists them; "
    "<font face='Courier'>GET /api/front/language/{id}</font> returns the bundle as parsed JSON in "
    "<font face='Courier'>data.languages</font>. Use <font face='Courier'>GET /api/front/default/language</font> on first launch.",
    BODY))

# 1.12
story.append(heading("1.12 Recommended Swift networking layer", H2, anchor='sec_1_12', label='1.12 Recommended Swift networking layer', outline_level=1))
story.append(Paragraph(
    "Sketch of an interceptor-style URLSession client. Adapt to your DI / Combine / async-await preference.",
    BODY))
story.append(code_block(
    "actor APIClient {\n"
    "    let baseURL = URL(string: \"https://api.asmishop.com/api\")!\n"
    "    let session: URLSession = .shared\n"
    "    var token: String? { TokenStore.shared.read() }\n\n"
    "    func send<T: Decodable>(_ method: String,\n"
    "                            _ path: String,\n"
    "                            query: [URLQueryItem] = [],\n"
    "                            body: Encodable? = nil,\n"
    "                            auth: Bool = false) async throws -> T {\n"
    "        var comps = URLComponents(url: baseURL.appendingPathComponent(path),\n"
    "                                  resolvingAgainstBaseURL: false)!\n"
    "        comps.queryItems = query.isEmpty ? nil : query\n"
    "        var req = URLRequest(url: comps.url!)\n"
    "        req.httpMethod = method\n"
    "        req.setValue(\"application/json\", forHTTPHeaderField: \"Accept\")\n"
    "        if let body {\n"
    "            req.setValue(\"application/json\", forHTTPHeaderField: \"Content-Type\")\n"
    "            req.httpBody = try JSONEncoder().encode(AnyEncodable(body))\n"
    "        }\n"
    "        if auth, let t = token {\n"
    "            req.setValue(\"Bearer \\(t)\", forHTTPHeaderField: \"Authorization\")\n"
    "        }\n"
    "        let (data, _) = try await session.data(for: req)\n"
    "        let envelope = try JSONDecoder().decode(APIResponse<T>.self, from: data)\n"
    "        guard envelope.status, let payload = envelope.data else {\n"
    "            throw APIClientError.fromEnvelope(envelope.error)\n"
    "        }\n"
    "        return payload\n"
    "    }\n"
    "}", dark=True))

story.append(PageBreak())

# --------------------------- 2. AUTH -----------------------------------------
story.append(heading("2. Authentication endpoints", H1, anchor='sec_2', label='2. Authentication endpoints'))
story.append(Paragraph(
    "All endpoints sit under <font face='Courier'>/api/user/*</font>. "
    "<font face='Courier'>logout</font>, <font face='Courier'>refresh/token</font> and "
    "<font face='Courier'>details</font> require a Bearer token; the rest are public.",
    BODY))

# 2.1 register
story.append(endpoint("POST", "/api/user/registration", anchor='ep_register'))
story.append(Paragraph("Create a new customer account and receive a JWT.", BODY))
story.append(Paragraph("Request body (application/json)", H4))
story.append(params_table([
    ('fullname', 'string', 'optional', 'Up to 255 chars.'),
    ('email',    'string', 'optional', 'Must be unique. Required if email-verification setting is on.'),
    ('phone',    'string', 'required', 'Login identifier. BD format (see §1.8).'),
    ('address',  'string', 'optional', 'Postal address.'),
    ('password', 'string', 'required', 'Plain text over HTTPS. No length rule enforced server-side — apply your own.'),
]))
story.append(Paragraph("cURL", H4))
story.append(code_block(
    "curl -X POST 'https://{host}/api/user/registration' \\\n"
    "  -H 'Accept: application/json' \\\n"
    "  -H 'Content-Type: application/json' \\\n"
    "  -d '{\n"
    "    \"fullname\":\"Jane Doe\",\n"
    "    \"email\":\"jane@example.com\",\n"
    "    \"phone\":\"01712345678\",\n"
    "    \"address\":\"Dhaka\",\n"
    "    \"password\":\"SecurePass!23\"\n"
    "  }'"))
story.append(Paragraph("Success (200)", H4))
story.append(code_block(
    '{\n'
    '  "status": true,\n'
    '  "data": {\n'
    '    "token": "eyJ0eXAi...<JWT>...",\n'
    '    "user":  { ...UserResource (see §6.1) }\n'
    '  },\n'
    '  "error": []\n'
    '}'))
story.append(Paragraph("Errors", H4))
story.append(code_block(
    '// validation\n'
    '{ "status": false, "data": [], "error": { "phone": ["The phone field is required."] } }\n\n'
    '// duplicate email\n'
    '{ "status": false, "data": [], "error": { "email": ["The email has already been taken."] } }\n\n'
    '// server exception\n'
    '{ "status": true,  "data": [], "error": { "message": "<exception message>" } }   // legacy quirk'))
story.append(note(
    "If <font face='Courier'>generalsettings.is_verification_email = 1</font>, the user is auto-logged-in but "
    "<font face='Courier'>UserResource.email_verified</font> stays 0 until the email link is clicked. "
    "Some flows (login) hard-block unverified accounts; check that flag."))

# 2.2 login
story.append(endpoint("POST", "/api/user/login", anchor='ep_login'))
story.append(Paragraph("Authenticate with phone + password. Returns JWT + UserResource.", BODY))
story.append(Paragraph("Request body", H4))
story.append(params_table([
    ('phone',    'string', 'required', 'Must match BD regex (§1.8). Used as identifier.'),
    ('email',    'string', 'optional', 'Currently informational; auth uses phone.'),
    ('password', 'string', 'required', ''),
]))
story.append(Paragraph("cURL", H4))
story.append(code_block(
    "curl -X POST 'https://{host}/api/user/login' \\\n"
    "  -H 'Accept: application/json' \\\n"
    "  -H 'Content-Type: application/json' \\\n"
    "  -d '{\"phone\":\"01712345678\",\"password\":\"SecurePass!23\"}'"))
story.append(Paragraph("Success (200)", H4))
story.append(code_block(
    '{\n'
    '  "status": true,\n'
    '  "data": {\n'
    '    "token":      "eyJ0eXAi...<JWT>...",\n'
    '    "expires_in": 3600,\n'
    '    "user":       { ...UserResource }\n'
    '  },\n'
    '  "error": []\n'
    '}'))
story.append(Paragraph("Errors", H4))
story.append(code_block(
    '// invalid credentials\n'
    '{ "status": false, "data": [], "error": { "message": "Email / password didn\'t match." } }\n\n'
    '// unverified email (when verification enabled)\n'
    '{ "status": false, "data": [], "error": { "message": "Your Email is not Verified!" } }\n\n'
    '// banned account\n'
    '{ "status": false, "data": [], "error": { "message": "Your Account Has Been Banned." } }'))

# 2.3 logout
story.append(endpoint("POST", "/api/user/logout", auth=True, anchor='ep_logout'))
story.append(Paragraph("Invalidate the current JWT (server-side blacklist). Empty body.", BODY))
story.append(code_block(
    "curl -X POST 'https://{host}/api/user/logout' \\\n"
    "  -H 'Authorization: Bearer <jwt>' \\\n"
    "  -H 'Accept: application/json'"))
story.append(code_block(
    '{ "status": true, "data": { "message": "Successfully logged out." }, "error": [] }'))

# 2.4 forgot
story.append(endpoint("POST", "/api/user/forgot", anchor='ep_forgot'))
story.append(Paragraph(
    "Generate a 6-character reset token. Token is e-mailed to the user; "
    "the API also returns it in the response so iOS can keep state.",
    BODY))
story.append(params_table([('email', 'string', 'required', 'Account email.')]))
story.append(code_block(
    '// success\n'
    '{ "status": true, "data": { "user_id": 123, "reset_token": "AB12CD" }, "error": [] }\n\n'
    '// not found\n'
    '{ "status": false, "data": [], "error": "Account not found" }'))

# 2.5 forgot/submit
story.append(endpoint("POST", "/api/user/forgot/submit", anchor='ep_forgot_submit'))
story.append(Paragraph("Set new password using the token from §2.4.", BODY))
story.append(params_table([
    ('user_id',          'int',    'required', 'From /forgot response.'),
    ('reset_token',      'string', 'required', '6-char token.'),
    ('new_password',     'string', 'required', ''),
    ('confirm_password', 'string', 'required', 'Must equal new_password.'),
]))
story.append(code_block(
    '// success\n'
    '{ "status": true, "data": { "message": "Password Changed Successfully" }, "error": [] }\n\n'
    '// mismatch\n'
    '{ "status": false, "data": [], "error": "New password & confirm password not match" }\n\n'
    '// invalid token\n'
    '{ "status": false, "data": [], "error": "Something is wrong" }'))

# 2.6 social login
story.append(endpoint("POST", "/api/user/social/login", anchor='ep_social'))
story.append(Paragraph(
    "Sign in or auto-create with provider profile (Google / Apple / Facebook). "
    "No password required — the iOS app must have completed OAuth itself.",
    BODY))
story.append(params_table([
    ('name',  'string', 'required', 'Display name from provider.'),
    ('email', 'string', 'required', 'Email from provider.'),
]))
story.append(code_block(
    '// existing user\n'
    '{ "status": true, "data": { "token": "<JWT>", "user": { ...raw user object } }, "error": [] }\n\n'
    '// new user (auto-created, auto-verified) — note: no `user` key\n'
    '{ "status": true, "data": { "token": "<JWT>" }, "error": [] }\n\n'
    '// banned\n'
    '{ "status": false, "data": [], "error": { "message": "Your Account Has Been Banned." } }'))
story.append(note(
    "On the new-user branch the response omits <font face='Courier'>user</font>. "
    "Follow up with <font face='Courier'>GET /api/user/details</font> to fetch the profile and unify both branches."))

# 2.7 refresh
story.append(endpoint("GET", "/api/user/refresh/token", auth=True, anchor='ep_refresh'))
story.append(Paragraph(
    "Refresh an active token. <b>Response is not wrapped</b> in the standard envelope.",
    BODY))
story.append(code_block(
    '{\n'
    '  "access_token": "<NEW_JWT>",\n'
    '  "token_type":   "bearer",\n'
    '  "expires_in":   3600\n'
    '}'))
story.append(Paragraph(
    "iOS strategy: fire this when the stored token is at 80% of its TTL, or on first 401 response, "
    "before retrying the original request.",
    BODY))

# 2.8 details
story.append(endpoint("GET", "/api/user/details", auth=True, anchor='ep_details'))
story.append(Paragraph("Return the authenticated user (UserResource — §6.1).", BODY))
story.append(code_block(
    "curl -X GET 'https://{host}/api/user/details' \\\n"
    "  -H 'Authorization: Bearer <jwt>' \\\n"
    "  -H 'Accept: application/json'"))
story.append(code_block('{ "status": true, "data": { ...UserResource }, "error": [] }'))

story.append(PageBreak())

# --------------------------- 3. PUBLIC FRONT ---------------------------------
story.append(heading("3. Public Frontend endpoints", H1, anchor='sec_3', label='3. Public Frontend endpoints'))
story.append(Paragraph(
    "All endpoints under <font face='Courier'>/api/front/*</font>. No authentication required.",
    BODY))

# 3.1 UI
story.append(heading("3.1 UI customization", H2, anchor='sec_3_1', label='3.1 UI customization', outline_level=1))

story.append(endpoint("GET", "/api/front/section-customization"))
story.append(Paragraph(
    "Page section visibility &amp; ordering for the home screen. Returns a "
    "<font face='Courier'>Pagesetting</font> row (raw fields) — pure feature flags / toggles.",
    SMALL))
story.append(code_block('{ "status": true, "data": { "section_categories": 1, "section_arrival": 1, ... }, "error": [] }'))

story.append(endpoint("GET", "/api/front/sliders"))
story.append(Paragraph("Mobile sliders ordered by <font face='Courier'>position</font>. SliderResource list (§6.7).", SMALL))
story.append(code_block(
    '{ "status": true, "data": [\n'
    '    { "id": 1, "subtitle": "Hot", "title": "Spring Sale", "small_text": "Up to 40%",\n'
    '      "image": "https://{host}/assets/images/sliders/abc.jpg", "redirect_url": "https://...",\n'
    '      "created_at": "...", "updated_at": "..." }\n'
    '  ], "error": [] }'))

story.append(endpoint("GET", "/api/front/banners"))
story.append(params_table([
    ('type', 'string', 'required', 'TopSmall | BottomSmall | Large.'),
]))
story.append(note("<font face='Courier'>type=Large</font> returns a single object; "
                  "<font face='Courier'>TopSmall</font> / <font face='Courier'>BottomSmall</font> return arrays."))

story.append(endpoint("GET", "/api/front/partners"))
story.append(Paragraph("PartnerResource list — id, image (URL), link.", SMALL))

story.append(endpoint("GET", "/api/front/services"))
story.append(Paragraph("Admin-defined services (user_id = 0). ServiceResource list.", SMALL))

story.append(endpoint("GET", "/api/front/deal-of-day"))
story.append(Paragraph("Deal countdown info: <font face='Courier'>{title, deal_details, time, image, link}</font>. Image is fully qualified.", SMALL))

story.append(endpoint("GET", "/api/front/arrival"))
story.append(Paragraph("New-arrival cards: <font face='Courier'>{id, title, photo, link}</font>.", SMALL))

# 3.2 Settings
story.append(heading("3.2 Settings, languages, currencies", H2, anchor='sec_3_2', label='3.2 Settings, languages, currencies', outline_level=1))

story.append(endpoint("GET", "/api/front/settings"))
story.append(params_table([
    ('name', 'string', 'required', 'generalsettings | pagesettings | socialsettings.'),
]))
story.append(Paragraph(
    "<b>generalsettings</b> contains feature toggles and tuning knobs your iOS app should cache at boot:",
    SMALL))
story.append(kv_table([
    ('is_verification_email', '0 | 1 — gate logins on email verify.'),
    ('is_reward', '0 | 1 — show the reward UI / earning history.'),
    ('reward_point', 'minimum points convertible.'),
    ('reward_dolar', 'rate of point → currency conversion.'),
    ('popular_count', 'used by todays/featured/products limit.'),
    ('user_image', 'fallback avatar filename.'),
    ('is_smtp', 'whether server uses SMTP (info only).'),
]))

story.append(endpoint("GET", "/api/front/languages"))
story.append(endpoint("GET", "/api/front/language/{id}"))
story.append(Paragraph(
    "<font face='Courier'>{ basic: Language, languages: { ...translations parsed JSON } }</font>.",
    SMALL))
story.append(endpoint("GET", "/api/front/default/language"))

story.append(endpoint("GET", "/api/front/currencies"))
story.append(endpoint("GET", "/api/front/currency/{id}"))
story.append(endpoint("GET", "/api/front/default/currency"))
story.append(Paragraph(
    "Currency: <font face='Courier'>{name, code, symbol, value (multiplier), sign (left|right), is_default}</font>.",
    SMALL))

# 3.3 Categories / search
story.append(heading("3.3 Categories, attributes, search", H2, anchor='sec_3_3', label='3.3 Categories, attributes, search', outline_level=1))

story.append(endpoint("GET", "/api/front/categories"))
story.append(Paragraph("All active categories. CategoryResource list (§6.8).", SMALL))

story.append(endpoint("GET", "/api/front/{id}/category"))
story.append(Paragraph("<font face='Courier'>{id}</font> = category_id. Returns single-element CategoryResource array.", SMALL))

story.append(endpoint("GET", "/api/front/{id}/subcategories"))
story.append(Paragraph("<font face='Courier'>{id}</font> = category_id. SubcategoryResource list.", SMALL))

story.append(endpoint("GET", "/api/front/{id}/childcategories"))
story.append(Paragraph("<font face='Courier'>{id}</font> = subcategory_id. ChildcategoryResource list.", SMALL))

story.append(endpoint("GET", "/api/front/attributes/{id}"))
story.append(params_table([
    ('id (path)', 'int',    'required', 'category, subcategory, or childcategory id.'),
    ('type',      'string', 'required', 'category | subcategory | childcategory.'),
]))

story.append(endpoint("GET", "/api/front/attributeoptions/{id}"))
story.append(Paragraph("<font face='Courier'>{id}</font> = attribute_id. AttributeOptionResource list.", SMALL))

story.append(endpoint("GET", "/api/front/category/product/search"))
story.append(Paragraph("Filter products inside a category. Same query semantics as <font face='Courier'>/search</font>.", SMALL))

story.append(endpoint("GET", "/api/front/search"))
story.append(params_table([
    ('search',         'string', 'optional', 'Free-text query.'),
    ('category',       'int',    'optional', ''),
    ('subcategory',    'int',    'optional', ''),
    ('childcategory',  'int',    'optional', ''),
    ('min',            'number', 'optional', 'Min price.'),
    ('max',            'number', 'optional', 'Max price.'),
    ('sort',           'string', 'optional', 'date_desc | date_asc | price_desc | price_asc.'),
    ('{attr_input}[]', 'array',  'optional', 'Attribute filter — repeated key (e.g. ?color[]=red&color[]=blue).'),
]))
story.append(Paragraph("Response: <font face='Courier'>data: [ProductlistResource]</font> (§6.2).", SMALL))

# 3.4 Products
story.append(heading("3.4 Products &amp; deals", H2, anchor='sec_3_4', label='3.4 Products & deals', outline_level=1))

story.append(endpoint("GET", "/api/front/products"))
story.append(params_table([
    ('type',         'string', 'optional', 'Physical | Digital | License | Listing.'),
    ('highlight',    'string', 'optional', 'featured | best | top | big | is_discount | hot | latest | trending | sale.'),
    ('product_type', 'string', 'optional', 'normal | affiliate.'),
    ('limit',        'int',    'optional', 'Max items returned (no pagination).'),
    ('paginate',     'int',    'optional', 'Per-page size; if &gt; 0, response is paginated.'),
]))
story.append(Paragraph("Returns ProductlistResource list (or paginated wrapper).", SMALL))

story.append(endpoint("GET", "/api/front/offers"))
story.append(params_table([
    ('min',    'number', 'optional', ''),
    ('max',    'number', 'optional', ''),
    ('sort',   'string', 'optional', 'date_desc | date_asc | price_desc | price_asc.'),
    ('search', 'string', 'optional', ''),
    ('pageby', 'int',    'optional', 'Page size.'),
]))
story.append(Paragraph("Discounted products (always paginated).", SMALL))

story.append(endpoint("GET", "/api/front/todays/featured/products"))
story.append(Paragraph("Top-N featured products (limit = generalsetting.popular_count).", SMALL))

story.append(endpoint("GET", "/api/front/flash/deal/products"))
story.append(Paragraph(
    "<font face='Courier'>{ flash_deal: {title, start_date, end_date}, products: [ProductlistResource] }</font>. "
    "If no active flash deal, response is HTTP 404 envelope.",
    SMALL))

story.append(endpoint("GET", "/api/front/vendor/products/{id}"))
story.append(params_table([
    ('id (path)', 'int',    'required', 'Vendor user_id.'),
    ('type',      'string', 'optional', 'normal | affiliate.'),
]))

# 3.5 Vendor
story.append(heading("3.5 Vendor / store", H2, anchor='sec_3_5', label='3.5 Vendor / store', outline_level=1))

story.append(endpoint("GET", "/api/front/store/{shop_name}"))
story.append(Paragraph(
    "<font face='Courier'>{shop_name}</font> is a slug (kebab-case). Server converts to spaces for lookup. "
    "Returns <font face='Courier'>{ vendor: VendorResource, services: [...], products: [ProductlistResource] }</font>.",
    SMALL))
story.append(params_table([
    ('shop_name (path)', 'string', 'required', 'Slug (e.g. "abc-store").'),
    ('min',              'number', 'optional', ''),
    ('max',              'number', 'optional', ''),
    ('sort',             'string', 'optional', 'date_desc | date_asc | price_desc | price_asc.'),
]))

story.append(endpoint("POST", "/api/front/store/contact"))
story.append(params_table([
    ('user_id',   'int',    'required', 'Sender user id.'),
    ('vendor_id', 'int',    'required', 'Recipient vendor id.'),
    ('subject',   'string', 'required', ''),
    ('message',   'string', 'required', ''),
]))

# 3.6 Product details
story.append(heading("3.6 Product details, ratings, comments", H2, anchor='sec_3_6', label='3.6 Product details, ratings, comments', outline_level=1))

story.append(endpoint("GET", "/api/front/product/{id}/details"))
story.append(Paragraph("Full product (ProductDetailsResource — §6.3).", SMALL))

story.append(endpoint("GET", "/api/front/product/{id}/ratings"))
story.append(Paragraph("RatingResource list (§6.10).", SMALL))

story.append(endpoint("GET", "/api/front/product/{id}/comments"))
story.append(Paragraph("CommentResource list, newest first; each item embeds <font face='Courier'>replies[]</font>.", SMALL))

story.append(endpoint("GET", "/api/front/product/{id}/replies"))
story.append(Paragraph("Here <font face='Courier'>{id}</font> is the comment_id. ReplyResource list.", SMALL))

# 3.7 Checkout
story.append(heading("3.7 Checkout &amp; shipping", H2, anchor='sec_3_7', label='3.7 Checkout & shipping', outline_level=1))

story.append(endpoint("POST", "/api/front/checkout"))
story.append(Paragraph(
    "Creates the order, writes vendor commissions, applies coupon / wallet / rewards, sends email, "
    "returns the payment-gateway redirect URL.",
    BODY))
story.append(params_table([
    ('items',          'json string | array', 'required',
     'Line items. JSON-stringified or array. Each item: '
     '<font face="Courier">{id, qty, size, color, size_qty, size_price, size_key, keys[], values[], prices[]}</font>.'),
    ('currency_code',  'string',  'required', 'ISO code (USD, BDT, ...).'),
    ('shipping[0]',    'int',     'required', 'Shipping option id.'),
    ('packaging[0]',   'int',     'required', 'Packaging option id.'),
    ('user_id',        'int',     'optional', 'Required for authenticated checkout / wallet / rewards.'),
    ('wallet_price',   'number',  'optional', 'Amount paid from wallet balance.'),
    ('tax',            'int',     'optional', 'state_id used for tax computation.'),
    ('coupon',         'string',  'optional', 'Coupon code.'),
    ('first_name',     'string',  'required', 'Billing.'),
    ('last_name',      'string',  'required', ''),
    ('email',          'string',  'required', ''),
    ('number',         'string',  'required', 'Billing phone.'),
    ('address1',       'string',  'required', ''),
    ('address2',       'string',  'optional', ''),
    ('country',        'string',  'required', ''),
    ('state',          'string',  'optional', ''),
    ('city',           'string',  'optional', ''),
    ('zip',            'string',  'optional', ''),
    ('payment_method', 'string',  'required', 'Slug — paypal | stripe | sslcommerz | ...'),
]))
story.append(Paragraph("Response", H4))
story.append(code_block(
    '{\n'
    '  "status": true,\n'
    '  "data": {\n'
    '    "order_number": "ORD-1A2B3C",\n'
    '    "payment_url":  "https://{host}/payment/checkout?order_number=ORD-1A2B3C"\n'
    '  },\n'
    '  "error": []\n'
    '}'))
story.append(note(
    "Open <font face='Courier'>payment_url</font> in <font face='Courier'>SFSafariViewController</font> "
    "or a sandboxed <font face='Courier'>WKWebView</font>. After the gateway redirects to your configured return URL, "
    "fetch <font face='Courier'>GET /api/front/order/details?order_number=...</font> to confirm status."))

story.append(endpoint("GET", "/api/front/get-shipping-packaging"))
story.append(Paragraph("Global shipping + packaging options (admin set, user_id=0).", SMALL))

story.append(endpoint("GET", "/api/front/vendor/wise/shipping-packaging"))
story.append(params_table([('vendor_ids', 'string', 'required', 'Comma-separated vendor ids.')]))

story.append(endpoint("GET", "/api/front/order/details"))
story.append(params_table([('order_number', 'string', 'required', 'Tracking number.')]))
story.append(Paragraph("OrderDetailsResource (§6.5).", SMALL))

story.append(endpoint("POST", "/api/front/checkout/update/{id}"))
story.append(params_table([
    ('id (path)', 'int',    'required', 'order_id.'),
    ('status',    'string', 'required', 'completed | declined | ...'),
    ('track_text','string', 'optional', ''),
]))
story.append(Paragraph("Declined orders trigger inventory rollback and balance reversal.", SMALL))

story.append(endpoint("GET", "/api/front/checkout/delete/{id}"))

story.append(endpoint("GET", "/api/front/get/coupon-code"))
story.append(params_table([('coupon', 'string', 'required', 'Code to validate.')]))
story.append(Paragraph("Returns Coupon record if valid + within date range, otherwise error envelope.", SMALL))

story.append(endpoint("GET", "/api/front/get/countries"))
story.append(Paragraph("All countries with nested states &amp; cities — populate billing dropdowns.", SMALL))

# 3.8 Misc
story.append(heading("3.8 FAQs, blogs, pages, contact, tracking", H2, anchor='sec_3_8', label='3.8 FAQs, blogs, pages, contact, tracking', outline_level=1))

story.append(endpoint("GET", "/api/front/faqs"))
story.append(Paragraph("FaqResource list — id, title, details (HTML stripped).", SMALL))

story.append(endpoint("GET", "/api/front/blogs"))
story.append(params_table([('type', 'string', 'optional', '"latest" → returns last 6.')]))

story.append(endpoint("GET", "/api/front/pages"))
story.append(Paragraph("PageResource list (slug, content, meta_tag, header/footer flags).", SMALL))

story.append(endpoint("GET", "/api/front/ordertrack"))
story.append(params_table([('order_number', 'string', 'required', '')]))
story.append(Paragraph("Public order tracking — OrderTrackResource list (§6.6).", SMALL))

story.append(endpoint("POST", "/api/front/contactmail"))
story.append(params_table([
    ('name',    'string', 'required', ''),
    ('email',   'string', 'required', ''),
    ('phone',   'string', 'required', ''),
    ('message', 'string', 'required', ''),
]))

story.append(PageBreak())

# --------------------------- 4. USER (auth) ----------------------------------
story.append(heading("4. User endpoints (authenticated)", H1, anchor='sec_4', label='4. User endpoints (authenticated)'))
story.append(Paragraph(
    "All endpoints in this section live under <font face='Courier'>/api/user/*</font> "
    "and require <font face='Courier'>Authorization: Bearer &lt;jwt&gt;</font>. Standard envelope.",
    BODY))

# 4.1
story.append(heading("4.1 Dashboard &amp; profile", H2, anchor='sec_4_1', label='4.1 Dashboard & profile', outline_level=1))

story.append(endpoint("GET", "/api/user/dashboard", auth=True))
story.append(code_block(
    '{\n'
    '  "status": true,\n'
    '  "data": {\n'
    '    "user":             { ...UserResource },\n'
    '    "affilate_income":  "0.00",\n'
    '    "current_balance":  "120.50",\n'
    '    "completed_orders": 8,\n'
    '    "pending_orders":   2,\n'
    '    "recent_orders":    [ { ...OrderResource }, ... ]\n'
    '  },\n'
    '  "error": []\n'
    '}'))

story.append(endpoint("POST", "/api/user/profile/update", auth=True))
story.append(Paragraph("<b>multipart/form-data.</b>", SMALL))
story.append(params_table([
    ('name',    'string', 'required', ''),
    ('email',   'string', 'optional', 'Unique if provided.'),
    ('phone',   'string', 'required', ''),
    ('fax',     'string', 'optional', ''),
    ('city',    'string', 'optional', ''),
    ('country', 'string', 'optional', ''),
    ('zip',     'string', 'optional', ''),
    ('address', 'string', 'required', ''),
    ('photo',   'file',   'optional', 'jpeg | jpg | png | svg.'),
]))
story.append(Paragraph(
    "<b>Server ignores</b>: <font face='Courier'>shop_name, balance, is_vendor, ban, mail_sent, date, current_balance</font>. "
    "Sending them is harmless but wasted bytes.",
    SMALL))

story.append(endpoint("POST", "/api/user/password/update", auth=True))
story.append(params_table([
    ('current_password', 'string', 'required', ''),
    ('new_password',     'string', 'required', ''),
    ('renew_password',   'string', 'required', 'Must equal new_password.'),
]))

# 4.2
story.append(heading("4.2 Favorite vendors", H2, anchor='sec_4_2', label='4.2 Favorite vendors', outline_level=1))
story.append(endpoint("GET", "/api/user/favorite/vendors", auth=True))
story.append(Paragraph(
    "Returns array of <font face='Courier'>{id, shop_id, shop_name, owner_name, shop_address, shop_link}</font>.",
    SMALL))
story.append(endpoint("POST", "/api/user/favorite/store", auth=True))
story.append(params_table([('vendor_id', 'int', 'required', '')]))
story.append(endpoint("GET", "/api/user/favorite/delete/{id}", auth=True))
story.append(endpoint("GET", "/api/user/delete/user-account/{id}", auth=True))
story.append(danger("This permanently deletes the account and profile photo. Confirm with the user before calling."))

# 4.3
story.append(heading("4.3 Wishlist", H2, anchor='sec_4_3', label='4.3 Wishlist', outline_level=1))
story.append(endpoint("GET", "/api/user/wishlists", auth=True))
story.append(params_table([('sort', 'string', 'optional', 'date_desc | date_asc | price_asc | price_desc.')]))
story.append(Paragraph("Returns ProductlistResource list (only status=1 products).", SMALL))
story.append(endpoint("POST", "/api/user/wishlist/add", auth=True))
story.append(params_table([('product_id', 'int', 'required', '')]))
story.append(endpoint("GET", "/api/user/wishlist/remove/{id}", auth=True))
story.append(Paragraph("<font face='Courier'>{id}</font> = product_id.", SMALL))

# 4.4
story.append(heading("4.4 Orders", H2, anchor='sec_4_4', label='4.4 Orders', outline_level=1))
story.append(endpoint("GET", "/api/user/orders", auth=True))
story.append(params_table([('view', 'int', 'optional', 'Page size; default 12.')]))
story.append(Paragraph("Paginated OrderResource list (§6.4).", SMALL))
story.append(endpoint("GET", "/api/user/order/{id}/details", auth=True))
story.append(Paragraph("OrderDetailsResource (§6.5).", SMALL))
story.append(endpoint("POST", "/api/user/update/transactionid", auth=True))
story.append(params_table([
    ('order_id',       'int',    'required', ''),
    ('transaction_id', 'string', 'required', 'Gateway txnid.'),
]))

# 4.5
story.append(heading("4.5 Reviews / comments / replies / reports", H2, anchor='sec_4_5', label='4.5 Reviews / comments / replies / reports', outline_level=1))
story.append(endpoint("POST", "/api/user/reviewsubmit", auth=True))
story.append(Paragraph("Server checks the user actually purchased the product (completed order required).", SMALL))
story.append(params_table([
    ('user_id',    'int',    'required', ''),
    ('product_id', 'int',    'required', ''),
    ('rating',     'int',    'required', '1–5.'),
    ('comment',    'string', 'required', ''),
]))
story.append(endpoint("POST", "/api/user/commentstore", auth=True))
story.append(params_table([('product_id', 'int', 'required', ''), ('comment', 'string', 'required', '')]))
story.append(endpoint("POST", "/api/user/commentupdate", auth=True))
story.append(params_table([('id', 'int', 'required', 'comment_id.'), ('comment', 'string', 'required', '')]))
story.append(endpoint("GET", "/api/user/comment/{id}/delete", auth=True))
story.append(Paragraph("Deletes the comment <i>and</i> its replies.", SMALL))
story.append(endpoint("POST", "/api/user/replystore", auth=True))
story.append(params_table([('comment_id', 'int', 'required', ''), ('reply', 'string', 'required', '')]))
story.append(endpoint("POST", "/api/user/replyupdate", auth=True))
story.append(params_table([('id', 'int', 'required', 'reply_id.'), ('reply', 'string', 'required', '')]))
story.append(endpoint("GET", "/api/user/reply/{id}/delete", auth=True))
story.append(endpoint("POST", "/api/user/reportstore", auth=True))
story.append(params_table([
    ('product_id', 'int',    'required', ''),
    ('title',      'string', 'required', ''),
    ('note',       'string', 'required', 'Max 400 chars.'),
]))

# 4.6
story.append(heading("4.6 Messages (vendor)", H2, anchor='sec_4_6', label='4.6 Messages (vendor)', outline_level=1))
story.append(endpoint("GET", "/api/user/messages", auth=True))
story.append(Paragraph("ConversationResource list with embedded <font face='Courier'>messages[]</font> (§6.11).", SMALL))
story.append(endpoint("POST", "/api/user/message/store", auth=True))
story.append(Paragraph("Open a new conversation with a vendor (also emails them).", SMALL))
story.append(params_table([
    ('user_id', 'int',    'required', 'Sender id.'),
    ('email',   'string', 'required', 'Sender email — must exist in users.'),
    ('subject', 'string', 'required', ''),
    ('message', 'string', 'required', ''),
]))
story.append(endpoint("POST", "/api/user/message/post", auth=True))
story.append(Paragraph("Reply within an existing conversation.", SMALL))
story.append(params_table([
    ('conversation_id', 'int',    'required', ''),
    ('sent_user',       'int',    'required', ''),
    ('recieved_user',   'int',    'required', '<i>note spelling</i>.'),
    ('message',         'string', 'required', ''),
]))
story.append(endpoint("GET", "/api/user/message/{id}/delete", auth=True))
story.append(Paragraph("Deletes the conversation and <i>all</i> its messages.", SMALL))

# 4.7
story.append(heading("4.7 Tickets &amp; disputes", H2, anchor='sec_4_7', label='4.7 Tickets & disputes', outline_level=1))
story.append(endpoint("GET", "/api/user/tickets", auth=True))
story.append(endpoint("GET", "/api/user/disputes", auth=True))
story.append(endpoint("POST", "/api/user/ticket-dispute/store", auth=True))
story.append(params_table([
    ('subject',      'string', 'required', ''),
    ('message',      'string', 'required', ''),
    ('type',         'string', 'required', 'Ticket | Dispute.'),
    ('order_number', 'string', 'conditional', 'Required when type = Dispute.'),
]))
story.append(endpoint("GET", "/api/user/ticket-dispute/{id}/delete", auth=True))
story.append(endpoint("POST", "/api/user/ticket-dispute/message/store", auth=True))
story.append(params_table([
    ('user_id',         'int',    'required', 'Server overrides with auth user id.'),
    ('message',         'string', 'required', ''),
    ('conversation_id', 'int',    'required', ''),
]))

# 4.8
story.append(heading("4.8 Withdraw &amp; rewards", H2, anchor='sec_4_8', label='4.8 Withdraw & rewards', outline_level=1))
story.append(endpoint("GET", "/api/user/withdraws", auth=True))
story.append(Paragraph("WithdrawResource list — type='user', most recent first.", SMALL))
story.append(endpoint("GET", "/api/user/withdraw/methods/field", auth=True))
story.append(Paragraph(
    "Static catalog: PayPal, Skrill, Payoneer, Bank — each entry lists the form fields the API expects. "
    "Use this to render the dynamic form.",
    SMALL))
story.append(endpoint("POST", "/api/user/withdraw/create", auth=True))
story.append(params_table([
    ('methods',    'string', 'required', 'Method id.'),
    ('amount',     'number', 'required', '&gt; 0; checked against affilate_income balance.'),
    ('acc_email',  'string', 'optional', ''),
    ('iban',       'string', 'optional', ''),
    ('acc_name',   'string', 'optional', ''),
    ('address',    'string', 'optional', ''),
    ('swift',      'string', 'optional', ''),
    ('reference',  'string', 'optional', ''),
    ('acc_country','string', 'optional', ''),
]))
story.append(Paragraph("Returns WithdrawDetailsResource (§6.13).", SMALL))
story.append(endpoint("GET", "/api/user/reword/get", auth=True))
story.append(Paragraph("Reward-conversion history (Transactions where type=reward).", SMALL))
story.append(endpoint("POST", "/api/user/reword/store", auth=True))
story.append(params_table([
    ('reward_point', 'int', 'required', 'min = generalsetting.reward_point; max = current user.reward.'),
]))
story.append(note(
    "A separate proposed Reward / Preorder doc lives at <font face='Courier'>docs/REWARD_PREORDER_API.md</font>. "
    "It introduces <font face='Courier'>GET /api/front/reward/ladder</font> and "
    "<font face='Courier'>GET /api/user/reward/transactions</font>. "
    "Verify they exist on your environment before using."))

# 4.9
story.append(heading("4.9 Packages (vendor subscription)", H2, anchor='sec_4_9', label='4.9 Packages (vendor subscription)', outline_level=1))
story.append(endpoint("GET", "/api/user/packages", auth=True))
story.append(code_block(
    '{ "status": true, "data": {\n'
    '    "subs":             [ {id, title, subtitle, price}, ... ],\n'
    '    "currrent_package": { ...UserSubscription, "end_date": "31/05/2026" } | null\n'
    '  }, "error": [] }'))
story.append(Paragraph("<i>Note the typo:</i> <font face='Courier'>currrent_package</font> (3 r's). Backend bug, kept for compat.", SMALL))
story.append(endpoint("GET", "/api/user/package/details", auth=True))
story.append(params_table([('id', 'int', 'required', 'subscription_id (query param).')]))
story.append(endpoint("POST", "/api/user/package/store", auth=True))
story.append(params_table([
    ('method',          'string', 'required',    'Payment method.'),
    ('txnid',           'string', 'required',    'Gateway txnid.'),
    ('subscription_id', 'int',    'required',    ''),
    ('shop_name',       'string', 'conditional', 'Required when upgrading to vendor (is_vendor=0). Unique.'),
    ('owner_name',      'string', 'optional',    ''),
    ('shop_number',     'string', 'optional',    ''),
    ('shop_address',    'string', 'optional',    ''),
]))

# 4.10
story.append(heading("4.10 Deposit &amp; transactions", H2, anchor='sec_4_10', label='4.10 Deposit & transactions', outline_level=1))
story.append(endpoint("GET", "/api/user/deposits", auth=True))
story.append(Paragraph("Deposits; unpaid rows include <font face='Courier'>payment_url</font>.", SMALL))
story.append(endpoint("POST", "/api/user/deposit/store", auth=True))
story.append(params_table([
    ('amount',        'number', 'required', ''),
    ('currency_code', 'string', 'required', ''),
    ('method',        'string', 'optional', ''),
    ('txnid',         'string', 'optional', ''),
]))
story.append(Paragraph("Returns a payment route URL — open in WebView, then refresh dashboard.", SMALL))
story.append(endpoint("GET", "/api/user/transactions", auth=True))
story.append(endpoint("GET", "/api/user/transaction/details", auth=True))
story.append(params_table([('id', 'int', 'required', 'transaction id (query).')]))

story.append(PageBreak())

# --------------------------- 5. PAYMENT --------------------------------------
story.append(heading("5. Payment gateway endpoints", H1, anchor='sec_5', label='5. Payment gateway endpoints'))
story.append(Paragraph(
    "Mobile-payment routes are under <font face='Courier'>/user/api/...</font> "
    "(declared in <font face='Courier'>routes/customer.php</font>, not <font face='Courier'>routes/api.php</font>). "
    "All require an <i>authenticated session</i> — typically iOS opens the URL returned by "
    "<font face='Courier'>POST /api/user/deposit/store</font> (or the checkout payment URL) inside an in-app browser, "
    "and lets the gateway handle credentials &amp; redirects.",
    BODY))

pay_rows = [
    ('PayPal',         'POST', '/user/api/paypal-submit',                'GET /user/api/paypal/notify'),
    ('Stripe',         'POST', '/user/api/payment/stripe-submit',        'GET /user/api/payment/stripe/notify'),
    ('SSLCommerz',     'POST', '/user/api/ssl/submit',                   'POST /user/api/ssl/notify  (cancel: /api/ssl/cancle)'),
    ('Mollie',         'POST', '/user/api/molly/submit',                 'GET /user/api/molly/notify'),
    ('Instamojo',      'POST', '/user/api/instamojo/submit',             'GET /user/api/checkout/instamojo/notify'),
    ('Paystack',       'POST', '/user/api/paystack/submit',              '—'),
    ('PayTM',          'POST', '/user/api/paytm-submit',                 'POST /user/api/paytm-callback'),
    ('Razorpay',       'POST', '/user/api/razorpay-submit',              'POST /user/api/razorpay-callback'),
    ('Authorize.Net',  'POST', '/user/api/authorize-submit',             '—'),
    ('Voguepay',       'POST', '/user/api/voguepay/submit',              '—'),
    ('Mercadopago',    'POST', '/user/api/checkout/mercadopago/submit',  'GET .../mercadopago/return, POST .../notify'),
    ('Flutterwave',    'POST', '/user/api/flutter/submit',               'POST /user/api/flutter/notify'),
]
header = [Paragraph(f'<b>{h}</b>', SMALL) for h in ('Gateway', 'Method', 'Submit URL', 'Notify / Callback')]
body = [[Paragraph(g, SMALL),
         Paragraph(m, SMALL),
         Paragraph(f'<font face="Courier">{esc(s)}</font>', SMALL),
         Paragraph(f'<font face="Courier">{esc(n)}</font>', SMALL)] for g, m, s, n in pay_rows]
t = Table([header] + body, colWidths=[3 * cm, 1.6 * cm, 6.4 * cm, 6 * cm], hAlign='LEFT', repeatRows=1)
t.setStyle(TableStyle([
    ('GRID', (0, 0), (-1, -1), 0.4, colors.HexColor('#cfd8e3')),
    ('BACKGROUND', (0, 0), (-1, 0), colors.HexColor('#1a3a6c')),
    ('TEXTCOLOR', (0, 0), (-1, 0), colors.white),
    ('VALIGN', (0, 0), (-1, -1), 'TOP'),
    ('FONTSIZE', (0, 0), (-1, -1), 8.5),
]))
story.append(t)
story.append(Spacer(1, 8))

story.append(Paragraph("iOS deposit flow", H3))
story.append(code_block(
    "1. user enters amount + currency  ➞ POST /api/user/deposit/store\n"
    "2. server replies with `data.payment_url` (web route)\n"
    "3. open URL in SFSafariViewController OR WKWebView\n"
    "4. user completes payment on gateway\n"
    "5. gateway redirects to configured `return` URL (custom scheme / universal link)\n"
    "6. iOS captures the redirect, dismisses the WebView\n"
    "7. iOS calls GET /api/user/dashboard (or /transactions) to confirm balance changed"))

story.append(Paragraph("iOS checkout flow", H3))
story.append(code_block(
    "1. POST /api/front/checkout                  ➞ get { order_number, payment_url }\n"
    "2. open payment_url in SFSafariViewController\n"
    "3. on return: GET /api/front/order/details?order_number=...\n"
    "4. read `payment_status`, `status`         (Paid / Pending / Declined)\n"
    "5. on success: navigate to Order screen + clear cart"))

story.append(PageBreak())

# --------------------------- 6. RESOURCES ------------------------------------
story.append(heading("6. Resource shapes (appendix)", H1, anchor='sec_6', label='6. Resource shapes (appendix)'))
story.append(Paragraph(
    "Reference shapes for the most-used JSON resources. Field names are stable; nullable / conditional fields noted. "
    "Sample values are illustrative.",
    BODY))

# 6.1 UserResource
story.append(heading("6.1 UserResource", H2, anchor='res_user', label='6.1 UserResource', outline_level=1))
story.append(code_block(
    '{\n'
    '  "id":              123,\n'
    '  "full_name":       "Jane Doe",\n'
    '  "phone":           "01712345678",\n'
    '  "email":           "jane@example.com",\n'
    '  "fax":             null,\n'
    '  "propic":          "https://{host}/assets/images/users/abc.jpg",\n'
    '  "zip_code":        "1207",\n'
    '  "city":            "Dhaka",\n'
    '  "country":         "BD",\n'
    '  "address":         "123 Road, ...",\n'
    '  "balance":         "0.00",       // string\n'
    '  "reword":          250,           // reward POINTS (note spelling)\n'
    '  "email_verified":  1,             // 0|1\n'
    '  "affilate_code":   "ABCDEF",     // referral (note spelling)\n'
    '  "affilate_income": "0.00",       // string\n'
    '  "ban":             0              // 0|1\n'
    '}'))

# 6.2 ProductlistResource
story.append(heading("6.2 ProductlistResource", H2, anchor='res_prodlist', label='6.2 ProductlistResource', outline_level=1))
story.append(Paragraph("Product card shape (search results, product lists, wishlist, vendor store).", SMALL))
story.append(code_block(
    '{\n'
    '  "id":             42,\n'
    '  "title":          "Awesome Tee",\n'
    '  "thumbnail":      "https://{host}/assets/images/thumbnails/abc.jpg",\n'
    '  "rating":         "4.50",                  // string, 2 decimals\n'
    '  "current_price":  "850.00",                // already currency-converted (string)\n'
    '  "previous_price": "1000.00",               // null/"" if no discount (string)\n'
    '  "sale_end_date":  "2026-05-31 00:00:00",   // only when is_discount=1\n'
    '  "stock":          25,\n'
    '  "created_at":     "2026-01-01T12:00:00.000000Z",\n'
    '  "updated_at":     "2026-04-30T08:00:00.000000Z"\n'
    '}'))

# 6.3 ProductDetailsResource
story.append(heading("6.3 ProductDetailsResource", H2, anchor='res_proddetails', label='6.3 ProductDetailsResource', outline_level=1))
story.append(code_block(
    '{\n'
    '  "id":              42,\n'
    '  "user_id":         5,                                 // 0 = admin / platform shop\n'
    '  "title":           "Awesome Tee",\n'
    '  "type":            "Physical",\n'
    '  "attributes":      [ {"id":1,"name":"Color","options":[...]}, ... ] | null,\n'
    '  "thumbnail":       "https://{host}/assets/images/thumbnails/abc.jpg",\n'
    '  "first_image":     "https://{host}/assets/images/products/abc.jpg",\n'
    '  "images":          [ { "id": 11, "image": "https://.../galleries/x.jpg" }, ... ],\n'
    '  "rating":          "4.50",\n'
    '  "current_price":   "850.00",\n'
    '  "previous_price":  "1000.00",\n'
    '  "stock":           25,\n'
    '  "condition":       "New" | "Used"  // omitted when product_condition == 0\n'
    '  "video":           "https://www.youtube.com/...",\n'
    '  "stock_check":     0|1,\n'
    '  "estimated_shipping_time": "3-5 days",\n'
    '  "colors":          "Red,Blue,Green",       // CSV strings\n'
    '  "sizes":           "S,M,L",                // CSV\n'
    '  "size_quantity":   "10,15,5",              // CSV\n'
    '  "size_price":      "0,50,100",             // CSV (additional)\n'
    '  "details":         "<plain-text product description>",\n'
    '  "policy":          "<plain-text policy>",\n'
    '  "whole_sell_quantity": 50,\n'
    '  "whole_sell_discount": "10",\n'
    '  "reviews":         [ ...RatingResource ],\n'
    '  "comments":        [ ...CommentResource ],\n'
    '  "related_products":[ ...ProductlistResource (max 8) ],\n'
    '  "shop": { "name": "Acme Store", "items": "37 items" },\n'
    '  "created_at":      "...",\n'
    '  "updated_at":      "..."\n'
    '}'))

# 6.4 OrderResource
story.append(heading("6.4 OrderResource", H2, anchor='res_order', label='6.4 OrderResource', outline_level=1))
story.append(code_block(
    '{\n'
    '  "id":         901,\n'
    '  "number":     "ORD-1A2B3C",\n'
    '  "total":      "$120.50",            // already includes currency sign\n'
    '  "status":     "Pending",            // Pending|Processing|On Delivery|Completed|Declined\n'
    '  "details":    "https://{host}/user/order/901",   // web URL only\n'
    '  "created_at": "...",\n'
    '  "updated_at": "..."\n'
    '}'))

# 6.5 OrderDetailsResource
story.append(heading("6.5 OrderDetailsResource", H2, anchor='res_orderdetails', label='6.5 OrderDetailsResource', outline_level=1))
story.append(code_block(
    '{\n'
    '  "id":               901,\n'
    '  "number":           "ORD-1A2B3C",\n'
    '  "total":            "$120.50",\n'
    '  "status":           "Pending",\n'
    '  "payment_status":   "Pending",        // Paid | Pending | Declined\n'
    '  "method":           "stripe",\n'
    '  "payment_url":      "https://{host}/payment/checkout?order_number=ORD-1A2B3C" | null,\n'
    '  "shipping_name":    "Jane Doe",       // falls back to customer_name if shipping is empty\n'
    '  "shipping_email":   "jane@example.com",\n'
    '  "shipping_phone":   "01712345678",\n'
    '  "shipping_address": "...",\n'
    '  "shipping_zip":     "1207",\n'
    '  "shipping_city":    "Dhaka",\n'
    '  "shipping_country": "BD",\n'
    '  "customer_name":    "Jane Doe",\n'
    '  "customer_email":   "jane@example.com",\n'
    '  "customer_phone":   "01712345678",\n'
    '  "customer_address": "...",\n'
    '  "customer_zip":     "1207",\n'
    '  "customer_city":    "Dhaka",\n'
    '  "customer_country": "BD",\n'
    '  "shipping":         "Standard",       // shipping option name\n'
    '  "paid_amount":      "$120.50",\n'
    '  "payment_method":   "stripe",\n'
    '  "shipping_cost":    "5.00",\n'
    '  "packing_cost":     "1.50",\n'
    '  "charge_id":        "ch_3OwabcDEF...",\n'
    '  "transaction_id":   "txn_abc123",\n'
    '  "ordered_products": {\n'
    '    "0AbC": {\n'
    '      "item": {\n'
    '        "qty":   2,\n'
    '        "size":  "M",\n'
    '        "color": "Red",\n'
    '        "size_qty":   "10",\n'
    '        "size_price": "0",\n'
    '        "size_key":   "0",\n'
    '        "keys":   ["Color","Size"],\n'
    '        "values": ["Red","M"],\n'
    '        "prices": ["0","0"],\n'
    '        "item": {\n'
    '          "id": 42,\n'
    '          "name": "Awesome Tee",\n'
    '          "photo": "https://{host}/assets/images/products/abc.jpg",\n'
    '          "price": "850.00",\n'
    '          ... // raw product fields\n'
    '        }\n'
    '      }\n'
    '    }\n'
    '  },\n'
    '  "created_at": "...",\n'
    '  "updated_at": "..."\n'
    '}'))
story.append(note(
    "<font face='Courier'>ordered_products</font> is keyed with random suffixes — iterate values, "
    "do not depend on key names."))

# 6.6 OrderTrackResource
story.append(heading("6.6 OrderTrackResource", H2, anchor='res_ordertrack', label='6.6 OrderTrackResource', outline_level=1))
story.append(code_block(
    '{\n'
    '  "id":         5,\n'
    '  "order_id":   901,\n'
    '  "title":      "Order Placed",\n'
    '  "text":       "Your order has been received.",\n'
    '  "created_at": "...",\n'
    '  "updated_at": "..."\n'
    '}'))

# 6.7 Slider/Banner
story.append(heading("6.7 SliderResource / BannerResource", H2, anchor='res_slider', label='6.7 Slider / Banner', outline_level=1))
story.append(code_block(
    '// SliderResource\n'
    '{ "id":1, "subtitle":"Hot", "title":"Spring Sale", "small_text":"Up to 40%",\n'
    '  "image":"https://{host}/assets/images/sliders/abc.jpg",\n'
    '  "redirect_url":"https://...", "created_at":"...", "updated_at":"..." }\n\n'
    '// BannerResource\n'
    '{ "id":1, "image":"https://{host}/assets/images/banners/x.jpg",\n'
    '  "link":"https://...", "title":"Special", "text":"Limited time" }'))

# 6.8 Categories
story.append(heading("6.8 CategoryResource family", H2, anchor='res_category', label='6.8 Category family', outline_level=1))
story.append(code_block(
    '// CategoryResource\n'
    '{ "id":1, "name":"Electronics",\n'
    '  "icon":"https://{host}/assets/images/categories/icon.png",  // conditional\n'
    '  "banner":"https://{host}/assets/images/categories/banner.jpg",\n'
    '  "count":"42 items",\n'
    '  "subcategories":"https://{host}/api/front/1/subcategories",\n'
    '  "attributes":   "https://{host}/api/front/attributes/1?type=category",\n'
    '  "created_at":"...", "updated_at":"..." }\n\n'
    '// SubcategoryResource\n'
    '{ "id":11, "category_id":1, "name":"Phones",\n'
    '  "child_categories":"https://{host}/api/front/11/childcategories",\n'
    '  "attributes":      "https://{host}/api/front/attributes/11?type=subcategory",\n'
    '  "created_at":"...", "updated_at":"..." }\n\n'
    '// ChildcategoryResource\n'
    '{ "id":111, "subcategory_id":11, "name":"Smartphones",\n'
    '  "attributes":"https://{host}/api/front/attributes/111?type=childcategory",\n'
    '  "created_at":"...", "updated_at":"..." }'))

# 6.9 Attributes
story.append(heading("6.9 AttributeResource / AttributeOptionResource", H2, anchor='res_attr', label='6.9 Attribute / Option', outline_level=1))
story.append(code_block(
    '// AttributeResource\n'
    '{ "id":7, "attributable_id":1, "attributable_type":"App\\\\Models\\\\Category",\n'
    '  "name":"Color", "input_name":"color",\n'
    '  "attribute_options":"https://{host}/api/front/attributeoptions/7",\n'
    '  "created_at":"...", "updated_at":"..." }\n\n'
    '// AttributeOptionResource\n'
    '{ "id":21, "attribute_id":7, "name":"Red",\n'
    '  "created_at":"...", "updated_at":"..." }'))

# 6.10 Rating/Comment/Reply
story.append(heading("6.10 RatingResource / CommentResource / ReplyResource", H2, anchor='res_rating', label='6.10 Rating / Comment / Reply', outline_level=1))
story.append(code_block(
    '// RatingResource\n'
    '{ "id":1, "user_image":"https://{host}/assets/images/users/x.jpg",\n'
    '  "user_id":123, "name":"Jane Doe", "review":"Loved it!",\n'
    '  "rating":4.5, "review_date":"2026-04-15" }\n\n'
    '// CommentResource\n'
    '{ "id":3, "user_image":"https://{host}/assets/images/users/x.jpg",\n'
    '  "user_id":123, "name":"Jane Doe", "comment":"Sizing question?",\n'
    '  "replies":[ ...ReplyResource ], "created_at":"...", "updated_at":"..." }\n\n'
    '// ReplyResource\n'
    '{ "id":9, "user_image":"https://{host}/assets/images/users/y.jpg",\n'
    '  "user_id":124, "name":"Acme Store", "comment":"Runs true to size.",\n'
    '  "created_at":"...", "updated_at":"..." }'))

# 6.11 Conversation
story.append(heading("6.11 ConversationResource / Message", H2, anchor='res_conv', label='6.11 Conversation / Message', outline_level=1))
story.append(code_block(
    '// ConversationResource\n'
    '{ "id":12, "subject":"Order question", "sent_user":123, "recieved_user":5,\n'
    '  "message":"<initial body>",\n'
    '  "messages":[ ...ConversationMessageResource ],\n'
    '  "created_at":"...", "updated_at":"..." }\n\n'
    '// ConversationMessageResource\n'
    '{ "id":33, "conversation_id":12, "sent_user":5, "recieved_user":123,\n'
    '  "message":"Sure, ...", "created_at":"...", "updated_at":"..." }'))

# 6.12 Ticket
story.append(heading("6.12 TicketDisputeResource / Message", H2, anchor='res_ticket', label='6.12 Ticket / Dispute', outline_level=1))
story.append(code_block(
    '// TicketDisputeResource\n'
    '{ "id":7, "user_id":123, "subject":"Refund needed",\n'
    '  "message":"<initial body>", "type":"Dispute",\n'
    '  "order_number":"ORD-1A2B3C",       // conditional: only when type=Dispute\n'
    '  "messages":[ ...TicketDisputeMessageResource ],\n'
    '  "created_at":"...", "updated_at":"..." }\n\n'
    '// TicketDisputeMessageResource\n'
    '{ "id":15, "user_id":123, "conversation_id":7,\n'
    '  "message":"Any update?", "created_at":"...", "updated_at":"..." }'))

# 6.13 Withdraw
story.append(heading("6.13 WithdrawDetailsResource", H2, anchor='res_withdraw', label='6.13 WithdrawDetailsResource', outline_level=1))
story.append(code_block(
    '{ "id":4, "amount":50.00, "method":"Paypal", "acc_email":"jane@example.com",\n'
    '  "iban":"", "country":"", "acc_name":"", "address":"", "swift":"",\n'
    '  "reference":"", "status":"Pending" }'))

# 6.14 Package
story.append(heading("6.14 PackageResource", H2, anchor='res_package', label='6.14 PackageResource', outline_level=1))
story.append(code_block(
    '{ "id":2, "title":"Pro", "subtitle":"Unlimited products",\n'
    '  "price":29.00 }'))

# 6.15 Service / Vendor
story.append(heading("6.15 ServiceResource / VendorResource", H2, anchor='res_service', label='6.15 Service / Vendor', outline_level=1))
story.append(code_block(
    '// ServiceResource\n'
    '{ "id":1, "title":"Free shipping", "details":"On orders over $50",\n'
    '  "photo":"https://{host}/assets/images/services/x.png" }\n\n'
    '// VendorResource (extends UserResource with shop fields)\n'
    '{ ...UserResource fields...,\n'
    '  "shop_name":"Acme Store", "owner_name":"Jane Doe",\n'
    '  "shop_number":"01712345678", "shop_address":"...",\n'
    '  "shop_message":"...", "shop_details":"<html>...</html>",\n'
    '  "shop_image":"https://{host}/assets/images/vendorbanner/x.jpg",\n'
    '  "facebook":{"url":"https://...", "visibility":1},\n'
    '  "google":  {"url":"https://...", "status":1},\n'
    '  "twitter": {"url":"https://...", "status":1},\n'
    '  "linkedin":{"url":"https://...", "status":0} }'))

# 6.16 Faq/Blog/Page
story.append(heading("6.16 FaqResource / BlogResource / PageResource", H2, anchor='res_faq', label='6.16 Faq / Blog / Page', outline_level=1))
story.append(code_block(
    '// FaqResource\n'
    '{ "id":1, "title":"How do I track?", "details":"<plain text>" }\n\n'
    '// BlogResource\n'
    '{ "id":1, "title":"Top 10 ...", "details":"<plain text>",\n'
    '  "photo":"https://{host}/assets/images/blogs/x.jpg",\n'
    '  "source":"...", "views":342, "status":1,\n'
    '  "meta_tag":"...", "meta_description":"...", "tags":"...",\n'
    '  "created_at":"..." }\n\n'
    '// PageResource\n'
    '{ "id":1, "title":"About Us", "slug":"about-us",\n'
    '  "content":"<plain text>", "meta_tag":"...", "meta_description":"...",\n'
    '  "header":1, "footer":1 }'))

# 6.17 Featured / Partner / Gallery
story.append(heading("6.17 Featured links / banners / partners / gallery", H2, anchor='res_featured', label='6.17 Featured / Partners / Gallery', outline_level=1))
story.append(code_block(
    '// FeaturedLinkResource\n'
    '{ "id":1, "name":"Top Sellers", "link":"...",\n'
    '  "photo":"https://{host}/assets/images/featuredlink/x.jpg" }\n\n'
    '// FeaturedBannerResource\n'
    '{ "id":1, "link":"...",\n'
    '  "photo":"https://{host}/assets/images/featuredbanner/x.jpg" }\n\n'
    '// PartnerResource\n'
    '{ "id":1, "image":"https://{host}/assets/images/partner/x.png", "link":"..." }\n\n'
    '// GalleryResource\n'
    '{ "id":11, "image":"https://{host}/assets/images/galleries/y.jpg" }'))

# 6.18 Social
story.append(heading("6.18 SocialResource", H2, anchor='res_social', label='6.18 SocialResource', outline_level=1))
story.append(code_block(
    '{ "id":1,\n'
    '  "facebook":"https://...", "facebook_status":1,\n'
    '  "googleplus":"https://...", "google_status":1,\n'
    '  "twitter":"https://...",   "twitter_status":1,\n'
    '  "linkedin":"https://...",  "linkedin_status":0,\n'
    '  "dribble":"https://...",   "dribble_status":0 }'))

# 6.19 Report
story.append(heading("6.19 ReportResource", H2, anchor='res_report', label='6.19 ReportResource', outline_level=1))
story.append(code_block(
    '{ "id":1, "user_id":123, "product_id":42,\n'
    '  "title":"Counterfeit item", "note":"Long note ≤ 400 chars",\n'
    '  "created_at":"...", "updated_at":"..." }'))

story.append(PageBreak())

# --------------------------- 7. ERROR REFERENCE ------------------------------
story.append(heading("7. Error reference", H1, anchor='sec_7', label='7. Error reference'))
story.append(Paragraph(
    "Common error messages you should detect, plus suggested user-facing handling.",
    BODY))

err_rows = [
    ('"Email / password didn\'t match."',           'POST /api/user/login',           'Show inline error on password field. Do not log out.'),
    ('"Your Email is not Verified!"',                'POST /api/user/login',           'Open a "verify email" screen with resend CTA.'),
    ('"Your Account Has Been Banned."',              'login / social/login',           'Force logout, show support contact.'),
    ('{ "phone": ["..."] }',                         'login / registration',           'Field-level validation messages — bind to text field.'),
    ('"Account not found"',                           'POST /api/user/forgot',          'Show inline; suggest registration.'),
    ('"New password & confirm password not match"', 'POST /api/user/forgot/submit',   'Highlight both password fields.'),
    ('"Something is wrong"',                          'POST /api/user/forgot/submit',   'Likely expired token — restart flow.'),
    ('{ "message": "Not Found!" } (HTTP 404)',       'unknown route',                  'Programming error — show generic dialog.'),
    ('"Already added to favorite!"',                  'POST /api/user/favorite/store',  'Treat as success — disable button.'),
    ('"Already added to wishlist!"',                  'POST /api/user/wishlist/add',    'Treat as success — switch to "remove".'),
    ('"You can not buy this product"',                'POST /api/user/reviewsubmit',    'Show "purchase to review" message.'),
    ('"Insufficient balance"',                        'POST /api/user/withdraw/create', 'Show wallet balance + minimum threshold.'),
]
header = [Paragraph(f'<b>{h}</b>', SMALL) for h in ('Message', 'Source', 'Suggested handling')]
body = [[Paragraph(f'<font face="Courier" size="8">{esc(m)}</font>', SMALL),
         Paragraph(f'<font face="Courier" size="8">{esc(s)}</font>', SMALL),
         Paragraph(h, SMALL)] for m, s, h in err_rows]
t = Table([header] + body, colWidths=[6 * cm, 5 * cm, 6 * cm], hAlign='LEFT', repeatRows=1)
t.setStyle(TableStyle([
    ('GRID', (0, 0), (-1, -1), 0.4, colors.HexColor('#cfd8e3')),
    ('BACKGROUND', (0, 0), (-1, 0), colors.HexColor('#1a3a6c')),
    ('TEXTCOLOR', (0, 0), (-1, 0), colors.white),
    ('VALIGN', (0, 0), (-1, -1), 'TOP'),
    ('FONTSIZE', (0, 0), (-1, -1), 8),
]))
story.append(t)

story.append(PageBreak())

# --------------------------- 8. CHECKLIST ------------------------------------
story.append(heading("8. iOS integration checklist", H1, anchor='sec_8', label='8. iOS integration checklist'))
checklist = [
    "Confirm the <b>base host</b> with backend (staging vs production).",
    "Pick a phone-number masking lib that enforces BD format (§1.8) on the login screen.",
    "Implement a generic <font face='Courier'>APIResponse&lt;T&gt;</font> wrapper plus dual-shape error decoding "
    "(validation map / message / plain string).",
    "Centralize auth: a token store (Keychain), a refresh interceptor, and an auto-logout on "
    "<font face='Courier'>401</font> or banned-account error.",
    "Cache <font face='Courier'>default/currency</font> + <font face='Courier'>generalsettings</font> at app launch — "
    "they drive price formatting and feature toggles (rewards, email-verify).",
    "Use <font face='Courier'>GET /api/user/refresh/token</font> ahead of expiry (start at 80% of <font face='Courier'>expires_in</font>).",
    "For checkout, open the returned <font face='Courier'>payment_url</font> in <font face='Courier'>SFSafariViewController</font> "
    "with a custom-scheme return URL; on close, hit "
    "<font face='Courier'>GET /api/front/order/details?order_number=...</font> to confirm.",
    "Multipart upload (profile photo): set <font face='Courier'>Content-Type: multipart/form-data; boundary=...</font>; "
    "do not also send a JSON body.",
    "Pre-validate password match locally for <font face='Courier'>forgot/submit</font> and "
    "<font face='Courier'>password/update</font> to avoid a round-trip.",
    "Verify proposed reward endpoints in <font face='Courier'>docs/REWARD_PREORDER_API.md</font> have shipped "
    "before integrating; otherwise stick to <font face='Courier'>/reword/get</font>.",
    "All endpoints return HTTP 200 even on logical failure — always read <font face='Courier'>status</font> first.",
    "Image URLs are absolute (the API prepends <font face='Courier'>url('/')</font>) — do not prefix again.",
    "Use <font face='Courier'>Codable</font> for response bodies; treat field names as ground truth (incl. typos: "
    "<font face='Courier'>reword</font>, <font face='Courier'>recieved_user</font>, <font face='Courier'>currrent_package</font>).",
    "Persist cart state locally; the API has no server-side cart — <font face='Courier'>POST /api/front/checkout</font> "
    "is the only point at which cart contents reach the server.",
    "Watch out for <font face='Courier'>ordered_products</font> being a keyed map (random suffixes) — iterate values.",
    "Country / state / city dropdowns: cache <font face='Courier'>GET /api/front/get/countries</font> on first checkout.",
]
items = [ListItem(Paragraph(t, BODY)) for t in checklist]
story.append(ListFlowable(items, bulletType='1'))

story.append(PageBreak())

# --------------------------- 9. GLOSSARY -------------------------------------
story.append(heading("9. Glossary", H1, anchor='sec_9', label='9. Glossary'))
gloss = [
    ('JWT', 'JSON Web Token — used for stateless auth via Bearer header. Library: <font face="Courier">tymon/jwt-auth</font>.'),
    ('Envelope', 'The standard <font face="Courier">{status, data, error}</font> JSON wrapper used by most endpoints.'),
    ('UserResource', 'Server-side transformer for the User model — defines the public-facing shape of a user.'),
    ('Vendor', 'A user with <font face="Courier">is_vendor=2</font> and a populated <font face="Courier">shop_name</font>.'),
    ('reword', 'Reward points (note the spelling). Stored on user.reward; convertible to wallet balance via <font face="Courier">POST /reword/store</font>.'),
    ('Affilate income', 'Referral earnings (note spelling). Withdrawable via <font face="Courier">POST /api/user/withdraw/create</font>.'),
    ('Currency value', 'Multiplier vs base currency (USD). Server multiplies <font face="Courier">price &times; currency.value</font> in resources.'),
    ('Currency sign', '<font face="Courier">left</font> | <font face="Courier">right</font> — placement of the symbol.'),
    ('Highlight', 'Search filter for product lists: featured | best | top | big | hot | latest | trending | sale | is_discount.'),
    ('Order tracking', 'Public history of order events queried by <font face="Courier">order_number</font> via <font face="Courier">/api/front/ordertrack</font>.'),
    ('Pagesetting', 'Toggles for which home-screen sections are visible. Returned by <font face="Courier">/api/front/section-customization</font>.'),
    ('Generalsetting', 'Master configuration row — feature flags, reward rates, default images. Retrieve via <font face="Courier">/api/front/settings?name=generalsettings</font>.'),
]
gh = [Paragraph(f'<b>{h}</b>', SMALL) for h in ('Term', 'Definition')]
gb = [[Paragraph(k, SMALL), Paragraph(v, SMALL)] for k, v in gloss]
g = Table([gh] + gb, colWidths=[4 * cm, 13 * cm], hAlign='LEFT', repeatRows=1)
g.setStyle(TableStyle([
    ('GRID', (0, 0), (-1, -1), 0.4, colors.HexColor('#cfd8e3')),
    ('BACKGROUND', (0, 0), (-1, 0), colors.HexColor('#1a3a6c')),
    ('TEXTCOLOR', (0, 0), (-1, 0), colors.white),
    ('VALIGN', (0, 0), (-1, -1), 'TOP'),
]))
story.append(g)

story.append(Spacer(1, 1 * cm))
story.append(Paragraph(
    "<i>End of document. Questions / corrections — open an issue on the backend repo.</i>", SUBTITLE))

# ============================================================================
# BUILD
# ============================================================================

doc = APIDocTemplate(OUTPUT)
doc.build(story)
print(f"Wrote: {OUTPUT}")
