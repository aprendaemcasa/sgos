using System;
using System.Drawing;
using System.Linq;
using System.Windows.Forms;

namespace SGOS;

internal static class Program
{
    [STAThread]
    static void Main()
    {
        ApplicationConfiguration.Initialize();
        Application.Run(new LoginForm());
    }
}

internal static class Theme
{
    public static readonly Color Navy = Color.FromArgb(18, 30, 50);
    public static readonly Color Sidebar = Color.FromArgb(18, 30, 50);
    public static readonly Color Blue = Color.FromArgb(48, 112, 220);
    public static readonly Color BlueLight = Color.FromArgb(235, 242, 255);
    public static readonly Color Background = Color.FromArgb(245, 247, 251);
    public static readonly Color Surface = Color.White;
    public static readonly Color Text = Color.FromArgb(35, 47, 66);
    public static readonly Color Muted = Color.FromArgb(120, 132, 151);
    public static readonly Color Border = Color.FromArgb(226, 231, 239);
    public static readonly Color Green = Color.FromArgb(32, 151, 107);
    public static readonly Color Orange = Color.FromArgb(218, 143, 43);
    public static readonly Color Red = Color.FromArgb(205, 76, 76);

    public static Font Font(float size = 9.5f, FontStyle style = FontStyle.Regular) =>
        new Font("Segoe UI", size, style);

    public static Button Button(string text, bool primary = false)
    {
        var b = new Button
        {
            Text = text, Height = 40, AutoSize = true, Padding = new Padding(14, 0, 14, 0),
            FlatStyle = FlatStyle.Flat, BackColor = primary ? Blue : Surface,
            ForeColor = primary ? Color.White : Text, Font = Font(9, FontStyle.Bold),
            Cursor = Cursors.Hand, Margin = new Padding(4)
        };
        b.FlatAppearance.BorderSize = primary ? 0 : 1;
        b.FlatAppearance.BorderColor = Border;
        b.FlatAppearance.MouseOverBackColor = primary ? Color.FromArgb(35, 91, 190) : BlueLight;
        return b;
    }

    public static Label Label(string text, float size = 9.5f, FontStyle style = FontStyle.Regular, Color? color = null)
        => new Label { Text = text, AutoSize = true, Font = Font(size, style), ForeColor = color ?? Text };

    public static Panel Card(int width, int height)
        => new Panel { Size = new Size(width, height), BackColor = Surface, Padding = new Padding(18), Margin = new Padding(0, 0, 16, 16) };

    public static void StyleGrid(DataGridView grid)
    {
        grid.BorderStyle = BorderStyle.None;
        grid.BackgroundColor = Surface;
        grid.GridColor = Border;
        grid.EnableHeadersVisualStyles = false;
        grid.ColumnHeadersBorderStyle = DataGridViewHeaderBorderStyle.None;
        grid.ColumnHeadersHeight = 46;
        grid.ColumnHeadersDefaultCellStyle.BackColor = Color.FromArgb(246, 248, 252);
        grid.ColumnHeadersDefaultCellStyle.ForeColor = Muted;
        grid.ColumnHeadersDefaultCellStyle.Font = Font(8.5f, FontStyle.Bold);
        grid.ColumnHeadersDefaultCellStyle.Padding = new Padding(12, 0, 0, 0);
        grid.DefaultCellStyle.Font = Font(9.5f);
        grid.DefaultCellStyle.ForeColor = Text;
        grid.DefaultCellStyle.SelectionBackColor = BlueLight;
        grid.DefaultCellStyle.SelectionForeColor = Text;
        grid.DefaultCellStyle.Padding = new Padding(12, 5, 5, 5);
        grid.RowTemplate.Height = 44;
        grid.AlternatingRowsDefaultCellStyle.BackColor = Color.FromArgb(250, 251, 253);
        grid.RowHeadersVisible = false;
        grid.AllowUserToAddRows = false;
        grid.AllowUserToResizeRows = false;
        grid.ReadOnly = true;
        grid.SelectionMode = DataGridViewSelectionMode.FullRowSelect;
        grid.AutoSizeColumnsMode = DataGridViewAutoSizeColumnsMode.Fill;
    }
}

public class LoginForm : Form
{
    public LoginForm()
    {
        Text = "SGOS | Acesso";
        StartPosition = FormStartPosition.CenterScreen;
        Size = new Size(1000, 650);
        MinimumSize = new Size(850, 580);
        BackColor = Theme.Background;
        Font = Theme.Font();

        var brand = new Panel { Dock = DockStyle.Left, Width = 420, BackColor = Theme.Sidebar, Padding = new Padding(48) };
        brand.Controls.Add(Theme.Label("SGOS", 34, FontStyle.Bold, Color.White));
        brand.Controls[0].Location = new Point(48, 125);
        brand.Controls.Add(Theme.Label("GESTÃO DE SERVIÇOS", 9, FontStyle.Bold, Color.FromArgb(151, 183, 235)));
        brand.Controls[1].Location = new Point(52, 180);
        var headline = Theme.Label("Organização e controle\nem um só lugar.", 23, FontStyle.Bold, Color.White);
        headline.Location = new Point(48, 235);
        brand.Controls.Add(headline);
        var desc = Theme.Label("Uma interface demonstrativa para acompanhar\nclientes, serviços e ordens de serviço.", 10, FontStyle.Regular, Color.FromArgb(198, 208, 224));
        desc.Location = new Point(52, 320);
        brand.Controls.Add(desc);
        var footer = Theme.Label("SGOS  •  SISTEMA DE GERENCIAMENTO", 8, FontStyle.Bold, Color.FromArgb(145, 160, 183));
        footer.Location = new Point(52, 535);
        brand.Controls.Add(footer);
        Controls.Add(brand);

        var area = new Panel { Dock = DockStyle.Fill, BackColor = Theme.Background };
        Controls.Add(area);
        area.BringToFront();

        var card = new Panel { Size = new Size(410, 440), BackColor = Color.White, Location = new Point(65, 75), Padding = new Padding(34) };
        area.Controls.Add(card);
        card.Anchor = AnchorStyles.None;
        area.Resize += (_, _) => card.Location = new Point(Math.Max(20, (area.ClientSize.Width - card.Width) / 2), Math.Max(20, (area.ClientSize.Height - card.Height) / 2));

        var title = Theme.Label("Bem-vindo de volta", 22, FontStyle.Bold, Theme.Navy);
        title.Location = new Point(34, 35);
        card.Controls.Add(title);
        var subtitle = Theme.Label("Entre para visualizar o painel do SGOS.", 9.5f, FontStyle.Regular, Theme.Muted);
        subtitle.Location = new Point(37, 78);
        card.Controls.Add(subtitle);

        card.Controls.Add(FieldLabel("E-MAIL", 37, 135));
        var email = Input("seuemail@exemplo.com", 34, 158, 340);
        card.Controls.Add(email);
        card.Controls.Add(FieldLabel("SENHA", 37, 222));
        var password = Input("Digite sua senha", 34, 245, 340);
        password.UseSystemPasswordChar = true;
        card.Controls.Add(password);

        var enter = Theme.Button("Acessar painel   →", true);
        enter.Location = new Point(34, 315);
        enter.Size = new Size(340, 46);
        enter.Click += (_, _) => { Hide(); using var dashboard = new DashboardForm(); dashboard.ShowDialog(); Close(); };
        card.Controls.Add(enter);

        var note = Theme.Label("MODO DEMONSTRATIVO  •  ACESSO SEM VALIDAÇÃO", 7.5f, FontStyle.Bold, Theme.Muted);
        note.Location = new Point(42, 385);
        card.Controls.Add(note);
    }

    private static Label FieldLabel(string text, int x, int y)
    {
        var l = Theme.Label(text, 8, FontStyle.Bold, Theme.Muted);
        l.Location = new Point(x, y);
        return l;
    }

    private static TextBox Input(string placeholder, int x, int y, int width)
        => new TextBox { PlaceholderText = placeholder, Location = new Point(x, y), Width = width, Height = 34, Font = Theme.Font(10), BorderStyle = BorderStyle.FixedSingle };
}

public class DashboardForm : Form
{
    private readonly Panel page = new Panel();
    private readonly Panel sidebar = new Panel();
    private readonly Label pageTitle = new Label();
    private string activePage = "Visão geral";

    private readonly string[][] clients =
    {
        new[] { "CLI-001", "Maria Oliveira", "(99) 99999-1111", "maria@email.com", "Ativo" },
        new[] { "CLI-002", "João Santos", "(99) 99999-2222", "joao@email.com", "Ativo" },
        new[] { "CLI-003", "Ana Costa", "(99) 99999-3333", "ana@email.com", "Pendente" },
        new[] { "CLI-004", "Carlos Lima", "(99) 99999-4444", "carlos@email.com", "Ativo" }
    };

    private readonly string[][] services =
    {
        new[] { "SRV-001", "Manutenção preventiva", "R$ 150,00", "Ativo" },
        new[] { "SRV-002", "Instalação de equipamento", "R$ 250,00", "Ativo" },
        new[] { "SRV-003", "Configuração e suporte", "R$ 100,00", "Ativo" },
        new[] { "SRV-004", "Visita técnica", "R$ 80,00", "Inativo" }
    };

    private readonly string[][] orders =
    {
        new[] { "OS-1024", "Maria Oliveira", "Manutenção preventiva", "13/11/2026", "Em andamento" },
        new[] { "OS-1023", "João Santos", "Instalação", "12/11/2026", "Concluída" },
        new[] { "OS-1022", "Ana Costa", "Configuração", "11/11/2026", "Aguardando" },
        new[] { "OS-1021", "Carlos Lima", "Visita técnica", "10/11/2026", "Concluída" }
    };

    public DashboardForm()
    {
        Text = "SGOS | Painel de gerenciamento";
        WindowState = FormWindowState.Maximized;
        MinimumSize = new Size(1050, 680);
        BackColor = Theme.Background;
        Font = Theme.Font();

        sidebar.Dock = DockStyle.Left;
        sidebar.Width = 245;
        sidebar.BackColor = Theme.Sidebar;
        Controls.Add(sidebar);
        BuildSidebar();

        var top = new Panel { Dock = DockStyle.Top, Height = 72, BackColor = Color.White, Padding = new Padding(28, 0, 24, 0) };
        var breadcrumb = Theme.Label("SGOS  /  AMBIENTE DE GESTÃO", 8, FontStyle.Bold, Theme.Muted);
        breadcrumb.Location = new Point(28, 12);
        top.Controls.Add(breadcrumb);
        pageTitle.Text = "Visão geral";
        pageTitle.Font = Theme.Font(13, FontStyle.Bold);
        pageTitle.ForeColor = Theme.Navy;
        pageTitle.AutoSize = true;
        pageTitle.Location = new Point(28, 32);
        top.Controls.Add(pageTitle);
        var user = Theme.Label("●  Administrador", 9, FontStyle.Bold, Theme.Text);
        user.Anchor = AnchorStyles.Top | AnchorStyles.Right;
        user.Location = new Point(Width - 390, 28);
        top.Controls.Add(user);
        Controls.Add(top);

        page.Dock = DockStyle.Fill;
        page.BackColor = Theme.Background;
        page.Padding = new Padding(30, 25, 30, 25);
        page.AutoScroll = true;
        Controls.Add(page);
        page.BringToFront();
        top.BringToFront();
        ShowDashboard();
    }

    private void BuildSidebar()
    {
        var logo = Theme.Label("SGOS", 27, FontStyle.Bold, Color.White);
        logo.Location = new Point(25, 25);
        sidebar.Controls.Add(logo);
        var subtitle = Theme.Label("GESTÃO DE SERVIÇOS", 8, FontStyle.Bold, Color.FromArgb(155, 177, 210));
        subtitle.Location = new Point(29, 66);
        sidebar.Controls.Add(subtitle);
        var line = new Panel { Location = new Point(22, 100), Size = new Size(198, 1), BackColor = Color.FromArgb(52, 68, 91) };
        sidebar.Controls.Add(line);

        AddNav("▦", "Visão geral", 130, ShowDashboard);
        AddNav("♙", "Clientes", 180, () => ShowTable("Clientes", "Cadastro e consulta de clientes", new[] { "Código", "Nome", "Telefone", "E-mail", "Status" }, clients));
        AddNav("▤", "Serviços", 230, () => ShowTable("Serviços", "Catálogo de serviços disponíveis", new[] { "Código", "Descrição", "Valor", "Status" }, services));
        AddNav("▣", "Ordens de serviço", 280, () => ShowTable("Ordens de serviço", "Acompanhamento das solicitações", new[] { "Nº OS", "Cliente", "Serviço", "Abertura", "Status" }, orders));
        AddNav("⚙", "Usuários", 330, () => ShowTable("Usuários", "Perfis de acesso do sistema", new[] { "Código", "Nome", "E-mail", "Perfil", "Status" }, new[]
        {
            new[] { "USR-001", "Administrador", "admin@sgos.com", "Administrador", "Ativo" },
            new[] { "USR-002", "Atendente", "atendimento@sgos.com", "Operador", "Ativo" }
        }));

        var demo = new Panel { Location = new Point(16, 410), Size = new Size(213, 76), BackColor = Color.FromArgb(29, 46, 70) };
        demo.Controls.Add(Theme.Label("AMBIENTE DE TESTE", 8, FontStyle.Bold, Color.FromArgb(157, 190, 239)));
        demo.Controls[0].Location = new Point(14, 13);
        demo.Controls.Add(Theme.Label("Dados ilustrativos • sem banco", 8, FontStyle.Regular, Color.FromArgb(205, 215, 229)));
        demo.Controls[1].Location = new Point(14, 39);
        sidebar.Controls.Add(demo);
        AddNav("↪", "Sair do sistema", 520, Close);
    }

    private void AddNav(string icon, string title, int y, Action action)
    {
        var b = new Button
        {
            Text = icon + "     " + title, TextAlign = ContentAlignment.MiddleLeft,
            Location = new Point(14, y), Size = new Size(217, 42), FlatStyle = FlatStyle.Flat,
            BackColor = title == activePage ? Color.FromArgb(43, 91, 157) : Theme.Sidebar,
            ForeColor = Color.FromArgb(232, 238, 247), Font = Theme.Font(9.5f),
            Cursor = Cursors.Hand
        };
        b.FlatAppearance.BorderSize = 0;
        b.FlatAppearance.MouseOverBackColor = Color.FromArgb(37, 58, 86);
        b.Click += (_, _) => { activePage = title; action(); };
        sidebar.Controls.Add(b);
    }

    private void ResetPage(string title)
    {
        page.Controls.Clear();
        pageTitle.Text = title;
    }

    private void ShowDashboard()
    {
        ResetPage("Visão geral");
        var intro = Theme.Label("Resumo operacional", 22, FontStyle.Bold, Theme.Navy);
        intro.Location = new Point(30, 18);
        page.Controls.Add(intro);
        var sub = Theme.Label("Acompanhe os principais números e a movimentação do sistema.", 9.5f, FontStyle.Regular, Theme.Muted);
        sub.Location = new Point(33, 58);
        page.Controls.Add(sub);

        AddMetric("CLIENTES CADASTRADOS", "128", "Base de clientes", "♙", Theme.Blue, 30, 105);
        AddMetric("ORDENS EM ABERTO", "24", "Precisam de acompanhamento", "◷", Theme.Orange, 325, 105);
        AddMetric("SERVIÇOS CONCLUÍDOS", "86", "Finalizados no período", "✓", Theme.Green, 620, 105);

        var activity = Theme.Card(565, 285);
        activity.Location = new Point(30, 275);
        activity.Controls.Add(Theme.Label("Atividades recentes", 12, FontStyle.Bold, Theme.Navy));
        activity.Controls[0].Location = new Point(20, 18);
        AddActivity(activity, "Ordem de serviço #1024", "Manutenção preventiva • Em andamento", 65, Theme.Orange);
        AddActivity(activity, "Novo cliente cadastrado", "Maria Oliveira • Cadastro demonstrativo", 125, Theme.Blue);
        AddActivity(activity, "Ordem de serviço #1023", "Instalação • Concluída", 185, Theme.Green);
        page.Controls.Add(activity);

        var shortcuts = Theme.Card(310, 285);
        shortcuts.Location = new Point(620, 275);
        shortcuts.Controls.Add(Theme.Label("Acesso rápido", 12, FontStyle.Bold, Theme.Navy));
        shortcuts.Controls[0].Location = new Point(20, 18);
        AddShortcut(shortcuts, "Consultar clientes", 62, () => ShowTable("Clientes", "Cadastro e consulta de clientes", new[] { "Código", "Nome", "Telefone", "E-mail", "Status" }, clients));
        AddShortcut(shortcuts, "Consultar serviços", 112, () => ShowTable("Serviços", "Catálogo de serviços disponíveis", new[] { "Código", "Descrição", "Valor", "Status" }, services));
        AddShortcut(shortcuts, "Acompanhar ordens", 162, () => ShowTable("Ordens de serviço", "Acompanhamento das solicitações", new[] { "Nº OS", "Cliente", "Serviço", "Abertura", "Status" }, orders));
        page.Controls.Add(shortcuts);
    }

    private void AddMetric(string title, string value, string detail, string symbol, Color accent, int x, int y)
    {
        var card = Theme.Card(275, 145);
        card.Location = new Point(x, y);
        var stripe = new Panel { Location = new Point(0, 0), Size = new Size(4, 145), BackColor = accent };
        card.Controls.Add(stripe);
        var icon = new Label { Text = symbol, Location = new Point(218, 16), Size = new Size(38, 38), TextAlign = ContentAlignment.MiddleCenter, BackColor = Color.FromArgb(242, 246, 252), ForeColor = accent, Font = Theme.Font(16, FontStyle.Bold) };
        card.Controls.Add(icon);
        var heading = Theme.Label(title, 8, FontStyle.Bold, Theme.Muted);
        heading.Location = new Point(18, 18);
        card.Controls.Add(heading);
        var number = Theme.Label(value, 28, FontStyle.Bold, Theme.Navy);
        number.Location = new Point(18, 48);
        card.Controls.Add(number);
        var caption = Theme.Label(detail, 8.5f, FontStyle.Regular, Theme.Muted);
        caption.Location = new Point(20, 108);
        card.Controls.Add(caption);
        page.Controls.Add(card);
    }

    private void AddActivity(Panel p, string title, string detail, int y, Color accent)
    {
        p.Controls.Add(new Panel { Location = new Point(20, y), Size = new Size(4, 40), BackColor = accent });
        var a = Theme.Label(title, 9.5f, FontStyle.Bold, Theme.Text);
        a.Location = new Point(36, y + 1);
        p.Controls.Add(a);
        var d = Theme.Label(detail, 8.5f, FontStyle.Regular, Theme.Muted);
        d.Location = new Point(36, y + 22);
        p.Controls.Add(d);
    }

    private void AddShortcut(Panel p, string text, int y, Action action)
    {
        var b = Theme.Button("→   " + text);
        b.Location = new Point(18, y);
        b.Size = new Size(270, 39);
        b.TextAlign = ContentAlignment.MiddleLeft;
        b.Click += (_, _) => action();
        p.Controls.Add(b);
    }

    private void ShowTable(string title, string description, string[] columns, string[][] rows)
    {
        ResetPage(title);
        var heading = Theme.Label(title, 22, FontStyle.Bold, Theme.Navy);
        heading.Location = new Point(30, 18);
        page.Controls.Add(heading);
        var sub = Theme.Label(description, 9.5f, FontStyle.Regular, Theme.Muted);
        sub.Location = new Point(33, 58);
        page.Controls.Add(sub);

        var toolbar = new Panel { Location = new Point(30, 100), Size = new Size(900, 58), BackColor = Color.White, Anchor = AnchorStyles.Top | AnchorStyles.Left | AnchorStyles.Right };
        var search = new TextBox { PlaceholderText = "Pesquisar nesta lista...", Location = new Point(15, 14), Size = new Size(300, 30), Font = Theme.Font(9.5f), BorderStyle = BorderStyle.FixedSingle };
        toolbar.Controls.Add(search);
        var demoButton = Theme.Button("+  Novo registro", true);
        demoButton.Location = new Point(730, 8);
        demoButton.Anchor = AnchorStyles.Top | AnchorStyles.Right;
        demoButton.Click += (_, _) => MessageBox.Show("Esta é uma interface demonstrativa. O cadastro e a gravação de dados ainda não estão implementados.", "Modo demonstrativo", MessageBoxButtons.OK, MessageBoxIcon.Information);
        toolbar.Controls.Add(demoButton);
        page.Controls.Add(toolbar);

        var grid = new DataGridView { Location = new Point(30, 175), Size = new Size(900, 330), Anchor = AnchorStyles.Top | AnchorStyles.Left | AnchorStyles.Right | AnchorStyles.Bottom };
        Theme.StyleGrid(grid);
        foreach (var c in columns) grid.Columns.Add(c, c);
        foreach (var row in rows) grid.Rows.Add(row);
        if (grid.Columns.Contains("Status"))
        {
            grid.CellFormatting += (_, e) =>
            {
                if (grid.Columns[e.ColumnIndex].Name == "Status" && e.Value is string status)
                {
                    e.CellStyle.ForeColor = status == "Ativo" || status == "Concluída" ? Theme.Green :
                        status == "Inativo" ? Theme.Red : Theme.Orange;
                    e.CellStyle.Font = Theme.Font(9, FontStyle.Bold);
                }
            };
        }
        search.TextChanged += (_, _) =>
        {
            var term = search.Text.Trim();
            foreach (DataGridViewRow row in grid.Rows)
                row.Visible = string.IsNullOrEmpty(term) || row.Cells.Cast<DataGridViewCell>().Any(c => Convert.ToString(c.Value)?.Contains(term, StringComparison.OrdinalIgnoreCase) == true);
        };
        page.Controls.Add(grid);

        var count = Theme.Label($"{rows.Length} registro(s) demonstrativo(s)", 8.5f, FontStyle.Regular, Theme.Muted);
        count.Location = new Point(32, 520);
        page.Controls.Add(count);
        page.Resize += (_, _) =>
        {
            toolbar.Width = Math.Max(500, page.ClientSize.Width - 90);
            grid.Width = Math.Max(500, page.ClientSize.Width - 90);
            grid.Height = Math.Max(180, page.ClientSize.Height - 230);
            demoButton.Location = new Point(toolbar.Width - 165, 8);
        };
    }
}

public class ModuleForm : Form
{
    public ModuleForm(string title, string[] columns, string[][] rows)
    {
        Text = "SGOS | " + title;
        Size = new Size(950, 600);
        StartPosition = FormStartPosition.CenterParent;
        BackColor = Theme.Background;
        var header = new Panel { Dock = DockStyle.Top, Height = 78, BackColor = Color.White };
        var heading = Theme.Label(title, 21, FontStyle.Bold, Theme.Navy);
        heading.Location = new Point(25, 18);
        header.Controls.Add(heading);
        Controls.Add(header);
        var grid = new DataGridView { Dock = DockStyle.Fill };
        Theme.StyleGrid(grid);
        foreach (var c in columns) grid.Columns.Add(c, c);
        foreach (var r in rows) grid.Rows.Add(r);
        Controls.Add(grid);
        grid.BringToFront();
        header.BringToFront();
    }
}
