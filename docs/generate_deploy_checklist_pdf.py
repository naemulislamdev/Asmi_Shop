"""
Generate deployment checklist PDF for backend dev.
Output: docs/Asmi_Shop_Deploy_Checklist.pdf
"""

from reportlab.lib import colors
from reportlab.lib.pagesizes import A4
from reportlab.lib.styles import getSampleStyleSheet, ParagraphStyle
from reportlab.lib.units import cm
from reportlab.lib.enums import TA_LEFT
from reportlab.platypus import (
    SimpleDocTemplate, Paragraph, Spacer, PageBreak, Table, TableStyle,
    ListFlowable, ListItem, KeepTogether,
)

OUTPUT = r"G:\asmi_shop\asmi_shop_backend\docs\Asmi_Shop_Deploy_Checklist.pdf"

styles = getSampleStyleSheet()

TITLE = ParagraphStyle('TitleBig', parent=styles['Title'], fontSize=24, leading=28,
                       alignment=1, textColor=colors.HexColor('#1a3a6c'), spaceAfter=10)
SUB = ParagraphStyle('Sub', parent=styles['Normal'], fontSize=11, leading=14,
                     alignment=1, textColor=colors.HexColor('#555555'), spaceAfter=4)
H1 = ParagraphStyle('H1', parent=styles['Heading1'], fontSize=16, leading=20,
                    textColor=colors.HexColor('#1a3a6c'), spaceBefore=14, spaceAfter=8, keepWithNext=True)
H2 = ParagraphStyle('H2', parent=styles['Heading2'], fontSize=12, leading=15,
                    textColor=colors.HexColor('#264f8c'), spaceBefore=10, spaceAfter=4, keepWithNext=True)
BODY = ParagraphStyle('Body', parent=styles['BodyText'], fontSize=10, leading=14, spaceAfter=4)
SMALL = ParagraphStyle('Small', parent=styles['BodyText'], fontSize=9, leading=12, spaceAfter=2)
CODE = ParagraphStyle('Code', parent=styles['Code'], fontSize=9, leading=12,
                      backColor=colors.HexColor('#1f2d3d'),
                      textColor=colors.HexColor('#e6edf6'),
                      borderPadding=6, leftIndent=2, rightIndent=2,
                      spaceBefore=4, spaceAfter=8)
NOTE = ParagraphStyle('Note', parent=styles['BodyText'], fontSize=9, leading=12,
                      backColor=colors.HexColor('#fff4d6'), borderPadding=6,
                      leftIndent=2, rightIndent=2, spaceBefore=4, spaceAfter=8,
                      borderColor=colors.HexColor('#ecd58a'), borderWidth=0.4,
                      textColor=colors.HexColor('#5a4500'))


def esc(s):
    return s.replace('&', '&amp;').replace('<', '&lt;').replace('>', '&gt;')


def code(text):
    safe = esc(text).replace('\n', '<br/>').replace(' ', '&nbsp;')
    return Paragraph(f'<font face="Courier" size="9">{safe}</font>', CODE)


def file_table(rows):
    header = [Paragraph(f'<b>{h}</b>', SMALL) for h in ('#', 'File path', 'Action', 'What changed')]
    body = [[
        Paragraph(str(i + 1), SMALL),
        Paragraph(f'<font face="Courier" size="8.5">{esc(r[0])}</font>', SMALL),
        Paragraph(f'<b>{r[1]}</b>', SMALL),
        Paragraph(r[2], SMALL),
    ] for i, r in enumerate(rows)]
    t = Table([header] + body,
              colWidths=[0.7 * cm, 7.5 * cm, 1.8 * cm, 7 * cm],
              hAlign='LEFT', repeatRows=1)
    t.setStyle(TableStyle([
        ('GRID', (0, 0), (-1, -1), 0.4, colors.HexColor('#cfd8e3')),
        ('BACKGROUND', (0, 0), (-1, 0), colors.HexColor('#1a3a6c')),
        ('TEXTCOLOR', (0, 0), (-1, 0), colors.white),
        ('VALIGN', (0, 0), (-1, -1), 'TOP'),
        ('FONTSIZE', (0, 0), (-1, -1), 8.5),
        ('LEFTPADDING', (0, 0), (-1, -1), 4),
        ('RIGHTPADDING', (0, 0), (-1, -1), 4),
        ('TOPPADDING', (0, 0), (-1, -1), 3),
        ('BOTTOMPADDING', (0, 0), (-1, -1), 3),
    ]))
    return t


def route_table(rows):
    header = [Paragraph(f'<b>{h}</b>', SMALL) for h in ('Method', 'Path', 'Auth', 'Purpose')]
    body = []
    for m, p, a, d in rows:
        body.append([
            Paragraph(f'<font color="#0d6b3a"><b>{m}</b></font>', SMALL),
            Paragraph(f'<font face="Courier" size="8.5">{esc(p)}</font>', SMALL),
            Paragraph(a, SMALL),
            Paragraph(d, SMALL),
        ])
    t = Table([header] + body,
              colWidths=[1.5 * cm, 7 * cm, 1.5 * cm, 7 * cm],
              hAlign='LEFT', repeatRows=1)
    t.setStyle(TableStyle([
        ('GRID', (0, 0), (-1, -1), 0.4, colors.HexColor('#cfd8e3')),
        ('BACKGROUND', (0, 0), (-1, 0), colors.HexColor('#1a3a6c')),
        ('TEXTCOLOR', (0, 0), (-1, 0), colors.white),
        ('VALIGN', (0, 0), (-1, -1), 'TOP'),
        ('FONTSIZE', (0, 0), (-1, -1), 8),
    ]))
    return t


story = []

# Cover
story.append(Spacer(1, 1 * cm))
story.append(Paragraph("Asmi Shop Backend", TITLE))
story.append(Paragraph("Deployment Checklist", TITLE))
story.append(Spacer(1, 0.4 * cm))
story.append(Paragraph("Branch: <b>tahmid</b> &middot; Commit: <b>7d8e3b1</b>", SUB))
story.append(Paragraph("Repository: github.com/naemulislamdev/Asmi_Shop", SUB))
story.append(Spacer(1, 0.6 * cm))
story.append(Paragraph("Prepared by <b>Tahmid Alavi Ishmam</b>", SUB))

# 1. Summary
story.append(Paragraph("1. Summary", H1))
story.append(Paragraph(
    "This commit adds new customer-facing API endpoints so the Flutter app reaches feature parity with the website. "
    "Below is the exhaustive list of files you must deploy plus the post-deploy commands.",
    BODY))
story.append(Paragraph(
    "<b>Status check (already done by Tahmid):</b> partial deploy detected — "
    "<font face='Courier'>OfferController.php</font> and parts of <font face='Courier'>routes/api.php</font> are on the server, "
    "but the rest is missing. Hitting <font face='Courier'>/api/front/promo-offers</font> currently returns "
    "<font face='Courier'>Class App\\Http\\Resources\\PromoOfferResource not found</font>, "
    "and <font face='Courier'>/api/front/blog-categories</font> returns 404. Both confirm an incomplete pull.",
    NOTE))

# 2. Modified files
story.append(Paragraph("2. Modified files (server has older version)", H1))
story.append(file_table([
    ("app/Http/Controllers/Api/Auth/AuthController.php",
     "MODIFIED",
     "Added <b>loginByOrder</b>, <b>loginOtpRequest</b>, <b>loginOtpVerify</b> methods. Added Schema import. Updated middleware exception list."),
    ("app/Http/Controllers/Api/Front/CheckoutController.php",
     "MODIFIED",
     "Added <b>statesByCountry</b>, <b>citiesByState</b>, <b>walletCheck</b> methods. Added City model import."),
    ("app/Http/Controllers/Api/Front/FrontendController.php",
     "MODIFIED",
     "Added <b>blogShow</b>, <b>blogByCategory</b>, <b>blogByTag</b>, <b>blogSearch</b>, <b>blogCategories</b>, <b>subscribe</b>, <b>autosearch</b>. Updated <b>blogs</b> for pagination."),
    ("app/Http/Controllers/Api/User/ProfileController.php",
     "MODIFIED",
     "Added <b>affilateProgram</b>, <b>affilateHistory</b> methods."),
    ("routes/api.php",
     "MODIFIED",
     "Registered ~15 new routes (see Section 4)."),
]))

# 3. New files
story.append(Paragraph("3. New files (do not yet exist on server)", H1))
story.append(file_table([
    ("app/Http/Controllers/Api/Front/OfferController.php",
     "NEW",
     "Contains <b>promoOffers</b>, <b>promoOffer</b>, <b>conditionalOffers</b>, <b>conditionalOffer</b> methods."),
    ("app/Http/Resources/PromoOfferResource.php",
     "NEW",
     "API resource for PromoOffer model. Required by OfferController."),
    ("app/Http/Resources/ConditionalOfferResource.php",
     "NEW",
     "API resource for ConditionalOffer model. Required by OfferController."),
    ("database/migrations/2026_05_09_120000_add_force_password_change_to_users.php",
     "NEW",
     "Adds <b>force_password_change</b> + <b>auto_created_via</b> columns to <b>users</b> table. Run <font face='Courier'>php artisan migrate</font> after pull."),
]))

# 4. Routes
story.append(PageBreak())
story.append(Paragraph("4. New routes", H1))
story.append(Paragraph("All routes mounted under <font face='Courier'>/api</font> prefix.", BODY))

story.append(Paragraph("4.1 Auth (public)", H2))
story.append(route_table([
    ("POST", "/api/user/login/by-order", "no",
     "Auto sign-in (or create) from phone + order_number after guest checkout."),
    ("POST", "/api/user/login/otp/request", "no",
     "Send Vonage SMS OTP to user phone."),
    ("POST", "/api/user/login/otp/verify", "no",
     "Verify OTP, return JWT."),
]))

story.append(Paragraph("4.2 Frontend (public)", H2))
story.append(route_table([
    ("GET", "/api/front/blog/{slug}", "no", "Blog detail by slug (increments views)."),
    ("GET", "/api/front/blog/category/{slug}", "no", "Blogs filtered by category slug."),
    ("GET", "/api/front/blog/tag/{slug}", "no", "Blogs whose tags contain the slug."),
    ("GET", "/api/front/blog-search", "no", "?search=... — title/details search."),
    ("GET", "/api/front/blog-categories", "no", "Public blog category list with counts."),
    ("POST", "/api/front/subscribe", "no", "Newsletter subscribe by email."),
    ("GET", "/api/front/autosearch", "no", "?q=... — top 10 product matches for autocomplete."),
    ("GET", "/api/front/states/{country_id}", "no", "States for a country."),
    ("GET", "/api/front/cities/{state_id}", "no", "Cities for a state."),
    ("GET", "/api/front/promo-offers", "no", "Active promo offers list."),
    ("GET", "/api/front/promo-offer/{id}", "no", "Single promo offer with populated products."),
    ("GET", "/api/front/conditional-offers", "no", "Active conditional offers list."),
    ("GET", "/api/front/conditional-offer/{id}", "no", "Single conditional offer."),
]))

story.append(Paragraph("4.3 User (auth:api)", H2))
story.append(route_table([
    ("GET", "/api/user/wallet/check", "yes", "?amount=&total= — validate partial wallet payment."),
    ("GET", "/api/user/affilate/program", "yes", "Referral code, income, referrals."),
    ("GET", "/api/user/affilate/history", "yes", "Affiliate withdrawals."),
]))

# 5. Deploy commands
story.append(PageBreak())
story.append(Paragraph("5. Deploy commands", H1))
story.append(Paragraph("Run on the server, in the Laravel project root:", BODY))
story.append(code(
    "cd /home/asmishop/htdocs/asmishop.com\n"
    "\n"
    "# Pull the branch (replace existing local state if needed)\n"
    "git fetch origin\n"
    "git checkout tahmid\n"
    "git pull origin tahmid\n"
    "\n"
    "# Rebuild autoloader so PHP can find new classes\n"
    "composer dump-autoload -o\n"
    "\n"
    "# Apply new migration (force_password_change + auto_created_via cols)\n"
    "php artisan migrate\n"
    "\n"
    "# Clear cached config / routes / views / app cache\n"
    "php artisan config:clear\n"
    "php artisan route:clear\n"
    "php artisan cache:clear\n"
    "php artisan view:clear\n"
    "\n"
    "# Optional: re-cache for prod performance\n"
    "php artisan config:cache\n"
    "php artisan route:cache"))

story.append(Paragraph(
    "<b>Why <font face='Courier'>composer dump-autoload</font> is critical:</b> "
    "Without it PHP cannot locate the new <font face='Courier'>PromoOfferResource</font> / "
    "<font face='Courier'>ConditionalOfferResource</font> classes (this is exactly the current error).",
    NOTE))

# 6. Verify
story.append(Paragraph("6. Post-deploy verification", H1))
story.append(Paragraph(
    "Run these curls — every endpoint should return "
    "<font face='Courier'>{\"status\":true,\"data\":[...],\"error\":[]}</font>:",
    BODY))
story.append(code(
    'curl https://asmishop.com/api/front/promo-offers\n'
    'curl https://asmishop.com/api/front/conditional-offers\n'
    'curl https://asmishop.com/api/front/blog-categories\n'
    'curl "https://asmishop.com/api/front/autosearch?q=tea"\n'
    'curl "https://asmishop.com/api/front/blog-search?search=organic"\n'
    'curl https://asmishop.com/api/front/states/19\n'
    'curl https://asmishop.com/api/front/cities/1\n'
    '\n'
    '# Auth (public): expect 422-style validation error, not 404\n'
    'curl -X POST https://asmishop.com/api/user/login/by-order \\\n'
    '  -H "Content-Type: application/json" -d "{}"\n'
    'curl -X POST https://asmishop.com/api/user/login/otp/request \\\n'
    '  -H "Content-Type: application/json" -d "{}"'))

story.append(Paragraph(
    "If any response contains <font face='Courier'>Class not found</font> &mdash; the autoloader was not rebuilt; "
    "re-run <font face='Courier'>composer dump-autoload -o</font>.",
    NOTE))
story.append(Paragraph(
    "If any response says <font face='Courier'>Not Found!</font> &mdash; the routes cache is stale; "
    "re-run <font face='Courier'>php artisan route:clear</font>.",
    NOTE))

# 7. Summary count
story.append(Paragraph("7. Summary count", H1))
story.append(ListFlowable([
    ListItem(Paragraph("<b>4 controllers modified</b> (Auth, Checkout, Frontend, Profile)", BODY)),
    ListItem(Paragraph("<b>1 new controller</b> (OfferController)", BODY)),
    ListItem(Paragraph("<b>2 new resources</b> (PromoOfferResource, ConditionalOfferResource)", BODY)),
    ListItem(Paragraph("<b>1 new migration</b> (force_password_change + auto_created_via)", BODY)),
    ListItem(Paragraph("<b>1 routes file modified</b> (routes/api.php)", BODY)),
    ListItem(Paragraph("<b>~19 new endpoints</b> total", BODY)),
], bulletType='bullet'))

story.append(Spacer(1, 0.6 * cm))
story.append(Paragraph(
    "<i>Questions / issues: ping Tahmid.</i>",
    SUB))


doc = SimpleDocTemplate(OUTPUT, pagesize=A4,
                        leftMargin=1.8 * cm, rightMargin=1.8 * cm,
                        topMargin=1.8 * cm, bottomMargin=1.8 * cm,
                        title="Asmi Shop Backend Deployment Checklist",
                        author="Tahmid Alavi Ishmam")
doc.build(story)
print(f"Wrote: {OUTPUT}")
